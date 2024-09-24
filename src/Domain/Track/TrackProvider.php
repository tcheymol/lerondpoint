<?php

namespace App\Domain\Track;

use App\Entity\Track;
use App\Helper\AttachmentHelper;
use App\Repository\TrackRepository;
use Doctrine\Common\Collections\Collection;

readonly class TrackProvider
{
    public function __construct(
        private TrackRepository $trackRepository,
        private AttachmentHelper $attachmentHelper
    )
    {
    }

    /** @return array<Track> */
    public function provide(): array {
        $allTracks = $this->trackRepository->findAll();

        foreach ($allTracks as $track) {
            $this->attachmentHelper->hydrateTrackWithUrl($track);
        }

        return $allTracks;
    }
}
