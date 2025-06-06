<?php

namespace App\Twig\Runtime;

use App\Domain\Images\AttachmentHelper;
use App\Domain\Images\ThumbSize;
use App\Entity\Attachment;
use App\Entity\Track;
use App\Repository\TrackRepository;
use Doctrine\Common\Collections\Order;
use Twig\Extension\RuntimeExtensionInterface;

readonly class TrackPreviewExtensionRuntime implements RuntimeExtensionInterface
{
    public function __construct(
        private AttachmentHelper $attachmentHelper,
        private TrackRepository $repository,
    ) {
    }

    public function getTrackPreviewUrl(Track $track, ThumbSize $size = ThumbSize::Small): ?string
    {
        return $track->getCover() ? $this->getPreviewUrl($track->getCover(), $size) : null;
    }

    public function getPreviewUrl(Attachment $attachment, ThumbSize $size = ThumbSize::Small): ?string
    {
        return $attachment->getImageUrl($size) ?: $this->attachmentHelper->getThumbUrl($attachment, $size);
    }

    public function getPreviousTrackId(Track $track): ?int
    {
        return $this->repository->findAdjacentValidatedTrackId($track, Order::Descending);
    }

    public function getNextTrackId(Track $track): ?int
    {
        return $this->repository->findAdjacentValidatedTrackId($track, Order::Ascending);
    }
}
