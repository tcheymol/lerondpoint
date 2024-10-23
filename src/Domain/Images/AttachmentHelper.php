<?php

namespace App\Domain\Images;

use App\Entity\Attachment;
use Reconnect\S3Bundle\Service\FlysystemS3Client;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Uid\UuidV4;

readonly class AttachmentHelper
{
    public function __construct(private FlysystemS3Client $s3Adapter, private ThumbnailGenerator $thumbnailGenerator)
    {
    }

    public function createAttachment(UploadedFile $file): ?Attachment
    {
        try {
            $attachment = Attachment::fromFile($file);

            $this->uploadFile($file, $attachment);
            $this->uploadThumbnail($file, $attachment);
            $this->storeFileInfo($file, $attachment);

            unlink($file->getPathname());

            return $attachment;
        } catch (\Exception) {
            return null;
        }
    }

    public function hydrateWithUrl(Attachment $attachment): void
    {
        $attachment->url = $this->s3Adapter->getPreSignedUrl($attachment->getObjectId());
        $attachment->thumbnailUrl = $this->s3Adapter->getPreSignedUrl($attachment->getThumbnailObjectId());
    }

    /** @throws \Exception */
    private function uploadFile(UploadedFile $file, Attachment $attachment): void
    {
        $objectId = $this->s3Adapter->uploadFile($file, UuidV4::v4()->toString());
        $attachment->setObjectId($objectId);
    }

    /** @throws \Exception */
    private function uploadThumbnail(UploadedFile $file, Attachment $attachment): void
    {
        $thumbnailPath = $this->thumbnailGenerator->buildThumbnail($file);
        if ($thumbnailPath) {
            $thumbnailId = $this->s3Adapter->uploadFile(new File($thumbnailPath), UuidV4::v4()->toString());

            $attachment->setThumbnailObjectId($thumbnailId);
            unlink($thumbnailPath);
        }
    }

    private function storeFileInfo(UploadedFile $file, Attachment $attachment): void
    {
        $imageInfo = getimagesize($file);
        if ($imageInfo) {
            $attachment->setWidth($imageInfo[0])->setHeight($imageInfo[1]);
        }
    }
}