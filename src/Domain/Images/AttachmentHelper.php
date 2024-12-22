<?php

namespace App\Domain\Images;

use App\Entity\Attachment;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Reconnect\S3Bundle\Service\FlysystemS3Client;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Uid\UuidV4;

readonly class AttachmentHelper
{
    public function __construct(
        private EntityManagerInterface $em,
        private FlysystemS3Client $s3Adapter,
        private ThumbnailGenerator $thumbnailGenerator,
        private LoggerInterface $logger,
    ) {
    }

    public function createAttachment(?UploadedFile $file): ?Attachment
    {
        if (!$file) {
            return null;
        }
        try {
            $attachment = Attachment::fromFile($file);

            $this->uploadFile($file, $attachment);
            $this->uploadThumbnails($file, $attachment);
            $this->storeFileInfo($file, $attachment);

            unlink($file->getPathname());

            $this->em->persist($attachment);
            $this->em->flush();

            return $attachment;
        } catch (\Exception $e) {
            $this->logger->error(sprintf('Error while uploading attachment: %s', $e->getMessage()));

            return null;
        }
    }

    public function hydrateWithUrl(Attachment $attachment, ?ThumbSize $thumbSize = ThumbSize::Small): void
    {
        match ($thumbSize) {
            ThumbSize::Medium => $this->hydrateMediumThumbnailUrl($attachment),
            ThumbSize::Big => $this->hydrateBigThumbnailUrl($attachment),
            ThumbSize::Full => $this->hydratePreSignedUrl($attachment),
            default => $this->hydrateSmallThumbnailUrl($attachment),
        };
    }

    private function hydratePreSignedUrl(Attachment $attachment): void
    {
        $attachment->objectUrl = $this->s3Adapter->getPreSignedUrl($attachment->getObjectId());
    }

    private function hydrateSmallThumbnailUrl(Attachment $attachment): void
    {
        $attachment->smallThumbnailUrl = $this->s3Adapter->getPreSignedUrl($attachment->getThumbnailObjectId());
    }

    private function hydrateMediumThumbnailUrl(Attachment $attachment): void
    {
        $attachment->mediumThumbnailUrl = $this->s3Adapter->getPreSignedUrl($attachment->getMediumThumbnailObjectId());
    }

    private function hydrateBigThumbnailUrl(Attachment $attachment): void
    {
        $attachment->bigThumbnailUrl = $this->s3Adapter->getPreSignedUrl($attachment->getBigThumbnailObjectId());
    }

    /** @throws \Exception */
    private function uploadFile(UploadedFile $file, Attachment $attachment): void
    {
        $objectId = $this->s3Adapter->uploadFile($file, UuidV4::v4()->toString());
        $attachment->setObjectId($objectId);
    }

    /** @throws \Exception */
    private function uploadThumbnails(UploadedFile $file, Attachment $attachment): void
    {
        $attachment->setThumbnailObjectId($this->uploadThumbnail($file, $attachment));
        $attachment->setMediumThumbnailObjectId($this->uploadThumbnail($file, $attachment, 512));
        $attachment->setBigThumbnailObjectId($this->uploadThumbnail($file, $attachment, 1024));
    }

    /** @throws \Exception */
    public function uploadMissingThumbnails(Attachment $attachment): void
    {
        if (!$attachment->hasMissingThumbnail() || !$attachment->getObjectId()) {
            return;
        }

        $tempFilePath = new UuidV4();
        $this->s3Adapter->downloadFile($attachment->getObjectId(), $tempFilePath);
        $originalFile = new UploadedFile($tempFilePath, $tempFilePath);

        if (!$attachment->getThumbnailObjectId()) {
            $attachment->setThumbnailObjectId($this->uploadThumbnail($originalFile, $attachment));
        }
        if (!$attachment->getMediumThumbnailObjectId()) {
            $attachment->setMediumThumbnailObjectId($this->uploadThumbnail($originalFile, $attachment, 512));
        }
        if (!$attachment->getBigThumbnailObjectId()) {
            $attachment->setBigThumbnailObjectId($this->uploadThumbnail($originalFile, $attachment, 1024));
        }
    }

    /** @throws \Exception */
    private function uploadThumbnail(UploadedFile $file, Attachment $attachment, int $size = 255): ?string
    {
        $thumbnailPath = $this->thumbnailGenerator->buildThumbnail($file, $size);
        if ($thumbnailPath) {
            $thumbnailId = $this->s3Adapter->uploadFile(new File($thumbnailPath), UuidV4::v4()->toString());
            unlink($thumbnailPath);

            return $thumbnailId;
        }

        return null;
    }

    private function storeFileInfo(UploadedFile $file, Attachment $attachment): void
    {
        $imageInfo = getimagesize($file);
        if ($imageInfo) {
            $attachment->setWidth((string) $imageInfo[0])->setHeight((string) $imageInfo[1]);
        }
    }
}
