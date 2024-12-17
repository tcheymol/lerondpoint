<?php

namespace App\Domain\Track;

use App\Entity\Track;
use App\Form\Model\Search;
use App\Repository\TrackRepository;

readonly class TrackProvider
{
    public function __construct(
        private TrackRepository $trackRepository,
        private TrackAttachmentHelper $attachmentHelper,
    ) {
    }

    /** @return array<Track> */
    public function provide(Search $search): array
    {
        $searchText = $search->text;
        $allTracks = $searchText
            ? $this->trackRepository->search($searchText)
            : $this->trackRepository->findAll();

        foreach ($allTracks as $track) {
            $this->attachmentHelper->hydrateTrackWithUrl($track, 'small');
        }

        return $allTracks;
    }
}
