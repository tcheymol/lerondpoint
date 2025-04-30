<?php

namespace App\Twig\Runtime;

use App\Domain\Images\AttachmentHelper;
use App\Domain\Images\ThumbSize;
use App\Domain\Track\TrackAttachmentHelper;
use App\Entity\Attachment;
use App\Entity\Track;
use Twig\Extension\RuntimeExtensionInterface;

readonly class TrackPreviewExtensionRuntime implements RuntimeExtensionInterface
{
    public function __construct(
        private TrackAttachmentHelper $trackHelper,
        private AttachmentHelper $attachmentHelper,
    ) {
    }

    public function computePreviewUrl(Track $track, ThumbSize $size = ThumbSize::Small): string
    {
        if ($track->getUrl()) {
            return $track->getUrl();
        }

        $this->trackHelper->hydrateTrackWithUrl($track, $size);

        return $track->getThumbnailUrl($size) ?? '';
    }

    public function computeAttachmentPreviewUrl(Attachment $attachment, ThumbSize $size = ThumbSize::Small): string
    {
        if ($attachment->getUrl()) {
            return $attachment->getUrl();
        }

        $this->attachmentHelper->hydrateWithUrl($attachment, $size);

        return $attachment->getUrl($size) ?? '';
    }
}
