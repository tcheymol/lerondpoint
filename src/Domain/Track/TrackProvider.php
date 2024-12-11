<?php

namespace App\Domain\Track;

use App\Entity\Track;
use App\Repository\TrackRepository;

readonly class TrackProvider
{
    public function __construct(
        private TrackRepository $trackRepository,
        private TrackAttachmentHelper $attachmentHelper,
    ) {
    }

    /** @return array<Track> */
    public function provide(): array
    {
        $allTracks = $this->trackRepository->findAll();

        foreach ($allTracks as $track) {
            $this->attachmentHelper->hydrateTrackWithUrl($track);
        }

        return $allTracks;
    }
}
