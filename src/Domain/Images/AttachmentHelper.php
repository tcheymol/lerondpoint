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

    public function hydrateWithUrl(Attachment $attachment, ?string $thumbKind = null): void
    {
        $attachment->url = match ($thumbKind) {
            'small' => $this->s3Adapter->getPreSignedUrl($attachment->getThumbnailObjectId()),
            'medium' => $this->s3Adapter->getPreSignedUrl($attachment->getMediumThumbnailObjectId()),
            'big' => $this->s3Adapter->getPreSignedUrl($attachment->getBigThumbnailObjectId()),
            default => $this->s3Adapter->getPreSignedUrl($attachment->getObjectId()),
        };
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
