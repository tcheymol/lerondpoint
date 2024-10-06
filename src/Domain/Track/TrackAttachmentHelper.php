<?php

namespace App\Domain\Track;

use App\Domain\Images\AttachmentHelper;
use App\Entity\Track;

readonly class TrackAttachmentHelper
{
    public function __construct(private AttachmentHelper $attachmentHelper)
    {
    }

    public function handleAttachment(Track $track): void
    {
        $file = $track->uploadedFile;
        if (!$file) {
            return;
        }

        try {
            $attachment = $this->attachmentHelper->createAttachment($file);
            $track->addAttachment($attachment);
        } catch (\Exception) {
            return;
        }
    }

    public function hydrateTrackWithUrl(Track $track): Track
    {
        foreach ($track->getAttachments() as $attachment) {
            $this->attachmentHelper->hydrateWithUrl($attachment);
        }

        return $track;
    }
}