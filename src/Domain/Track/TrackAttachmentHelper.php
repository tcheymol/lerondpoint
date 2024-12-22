<?php

namespace App\Domain\Track;

use App\Domain\Images\AttachmentHelper;
use App\Domain\Images\ThumbSize;
use App\Entity\Track;
use App\Repository\AttachmentRepository;

readonly class TrackAttachmentHelper
{
    public function __construct(private AttachmentHelper $attachmentHelper, private AttachmentRepository $repository)
    {
    }

    public function handleAttachments(Track $track): void
    {
        foreach ($track->attachmentsIds as $attachmentId) {
            $track->addAttachment($this->repository->find($attachmentId));
        }
    }

    public function hydrateTrackWithUrl(Track $track, ?ThumbSize $thumbSize = null): Track
    {
        foreach ($track->getAttachments() as $attachment) {
            $this->attachmentHelper->hydrateWithUrl($attachment, $thumbSize);
        }

        return $track;
    }
}
