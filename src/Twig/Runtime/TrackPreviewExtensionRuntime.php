<?php

namespace App\Twig\Runtime;

use App\Domain\Images\ThumbSize;
use App\Domain\Track\TrackAttachmentHelper;
use App\Entity\Track;
use Twig\Extension\RuntimeExtensionInterface;

readonly class TrackPreviewExtensionRuntime implements RuntimeExtensionInterface
{
    public function __construct(private TrackAttachmentHelper $helper)
    {
    }

    public function computePreviewUrl(Track $track, ThumbSize $size = ThumbSize::Small): string
    {
        if ($track->getUrl()) {
            return $track->getUrl();
        }

        $this->helper->hydrateTrackWithUrl($track, $size);

        return $track->getThumbnailUrl($size) ?? '';
    }
}
