<?php

namespace App\Twig\Runtime;

use App\Domain\Images\AttachmentHelper;
use App\Domain\Images\ThumbSize;
use App\Entity\Attachment;
use App\Entity\Track;
use App\Repository\TrackRepository;
use Doctrine\Common\Collections\Order;
use Symfony\Component\Asset\Packages;
use Twig\Extension\RuntimeExtensionInterface;

readonly class TrackPreviewExtensionRuntime implements RuntimeExtensionInterface
{
    public function __construct(
        private AttachmentHelper $attachmentHelper,
        private TrackRepository $repository,
        private Packages $packages,
    ) {
    }

    public function getTrackThumbUrl(Track $track, ThumbSize $size = ThumbSize::Small): ?string
    {
        return $track->getCover() ? $this->getThumbUrl($track->getCover(), $size) : null;
    }

    public function getThumbUrl(Attachment $attachment, ThumbSize $size = ThumbSize::Small): ?string
    {
        if ($attachment->getImageUrl($size)) {
            return $attachment->getImageUrl($size);
        } elseif ($attachment->isVideo()) {
            return $this->packages->getUrl('images/fallback_video.png');
        }

        return $this->attachmentHelper->getThumbUrl($attachment, $size);
    }

    public function getPreviousTrackId(Track $track): ?int
    {
        return $this->repository->findAdjacentValidatedTrackId($track, Order::Descending);
    }

    public function getNextTrackId(Track $track): ?int
    {
        return $this->repository->findAdjacentValidatedTrackId($track, Order::Ascending);
    }

    public function getTrackNumber(Track $track): ?int
    {
        return $this->repository->getNumber($track);
    }
}
