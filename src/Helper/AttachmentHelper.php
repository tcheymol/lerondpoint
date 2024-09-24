<?php

namespace App\Helper;

use App\Entity\Attachment;
use App\Entity\Track;
use Doctrine\ORM\EntityManagerInterface;
use Reconnect\S3Bundle\Service\FlysystemS3Client;
use Symfony\Component\Uid\UuidV4;

readonly class AttachmentHelper
{
    public function __construct(private FlysystemS3Client $s3Adapter)
    {
    }

    public function handleAttachment(Track $track): void
    {
        $file = $track->uploadedFile;
        if (!$file) {
            return;
        }

        try {
            $objectId = UuidV4::v4();
            $this->s3Adapter->uploadFile($file, $objectId->toString());
            $attachment = Attachment::fromFile($file)->setObjectId($objectId);
            $track->addAttachment($attachment);
        } catch (\Exception $exception) {
            return;
        }
    }

    public function hydrateWithUrl(Attachment $attachment): void
    {
        $attachment->url = $this->s3Adapter->getPreSignedUrl($attachment->getObjectId()->toString());
    }

    public function hydrateTrackWithUrl(Track $track): Track
    {
        foreach ($track->getAttachments() as $attachment) {
            $this->hydrateWithUrl($attachment);
        }

        return $track;
    }
}