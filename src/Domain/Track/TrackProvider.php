<?php

namespace App\Domain\Track;

use App\Domain\Images\ThumbSize;
use App\Domain\Search\Search;
use App\Domain\Search\SearchPerformer;
use App\Entity\Track;
use App\Repository\TrackRepository;
use Doctrine\ORM\EntityManagerInterface;

readonly class TrackProvider
{
    public function __construct(
        private TrackRepository $trackRepository,
        private TrackAttachmentHelper $attachmentHelper,
        private SearchPerformer $searchPerformer,
        private EntityManagerInterface $em,
    ) {
    }

    /** @return array<Track> */
    public function provide(Search $search, ?ThumbSize $thumbSize = ThumbSize::Small): array
    {
        $this->em->getFilters()->enable('validated_entity');

        $allTracks = $search->isEmpty()
            ? $this->trackRepository->findAll()
            : $this->searchPerformer->search($search);

        return $this->hydrateTracks($allTracks, $thumbSize);
    }

    /** @return Track[] */
    public function provideToModerate(): array
    {
        return $this->hydrateTracks($this->trackRepository->findToModerate());
    }

    public function hydrateWithPreviousAndNextIds(Track $track): Track
    {
        $track->previousTrackId = $this->trackRepository->findPreviousValidatedTrack($track)?->getId();
        $track->nextTrackId = $this->trackRepository->findNextValidatedTrack($track)?->getId();

        return $track;
    }

    /**
     * @param Track[] $allTracks
     *
     * @return Track[]
     */
    private function hydrateTracks(array $allTracks, ?ThumbSize $thumbSize = ThumbSize::Small): array
    {
        foreach ($allTracks as $track) {
            $this->attachmentHelper->hydrateTrackWithUrl($track, $thumbSize);
        }

        return $allTracks;
    }
}
