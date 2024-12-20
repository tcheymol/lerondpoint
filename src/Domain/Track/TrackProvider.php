<?php

namespace App\Domain\Track;

use App\Domain\Search\Search;
use App\Domain\Search\SearchPerformer;
use App\Entity\Track;
use App\Repository\TrackRepository;

readonly class TrackProvider
{
    public function __construct(
        private TrackRepository $trackRepository,
        private TrackAttachmentHelper $attachmentHelper,
        private SearchPerformer $searchPerformer,
    ) {
    }

    /** @return array<Track> */
    public function provide(Search $search): array
    {
        $allTracks = $search->isEmpty()
            ? $this->trackRepository->findAll()
            : $this->searchPerformer->perform($search);

        foreach ($allTracks as $track) {
            $this->attachmentHelper->hydrateTrackWithUrl($track, 'small');
        }

        return $allTracks;
    }
}
