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

    public function getThumbUrl(Attachment $attachment, ThumbSize $size): ?string
    {
        return $this->s3Adapter->getPreSignedUrl($attachment->getImageObjectId($size));
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
        $attachment->setThumbnailObjectId($this->uploadThumbnail($file));
        $attachment->setMediumThumbnailObjectId($this->uploadThumbnail($file, 512));
        $attachment->setBigThumbnailObjectId($this->uploadThumbnail($file, 1024));
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
            $attachment->setThumbnailObjectId($this->uploadThumbnail($originalFile));
        }
        if (!$attachment->getMediumThumbnailObjectId()) {
            $attachment->setMediumThumbnailObjectId($this->uploadThumbnail($originalFile, 512));
        }
        if (!$attachment->getBigThumbnailObjectId()) {
            $attachment->setBigThumbnailObjectId($this->uploadThumbnail($originalFile, 1024));
        }
    }

    /** @throws \Exception */
    private function uploadThumbnail(UploadedFile $file, int $size = 255): ?string
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
        } elseif ('application/pdf' === $attachment->getKind()) {
            $attachment->setWidth('595')->setHeight('842');
        }
    }

    public function deleteObjects(Attachment $attachment): void
    {
        foreach ($attachment->getObjectIds() as $objectId) {
            try {
                $this->s3Adapter->deleteFile($objectId);
            } catch (\Exception $e) {
                $this->logger->error(sprintf('Error while deleting attachment %s objet with id %s: %s', $attachment->getId(), $objectId, $e->getMessage()));
            }
        }
    }
}
