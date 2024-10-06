<?php

namespace App\Domain\Images;

use App\Entity\Attachment;
use Reconnect\S3Bundle\Service\FlysystemS3Client;
use Symfony\Component\HttpFoundation\File\UploadedFile;

readonly class AttachmentHelper
{
    public function __construct(private ImageProcessor $imageProcessor, private FlysystemS3Client $s3Adapter)
    {
    }

    public function createAttachment(UploadedFile $file): ?Attachment
    {
        try {
            $objectId = $this->imageProcessor->uploadFile($file);
            $thumbId = $this->imageProcessor->generateThumbnail($file);

            $attachment = Attachment::fromFile($file)
                ->setObjectId($objectId)
                ->setThumbnailObjectId($thumbId);

            $imageInfo = getimagesize($file);
            if ($imageInfo) {
                $attachment->setWidth($imageInfo[0])->setHeight($imageInfo[1]);
            }

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
}