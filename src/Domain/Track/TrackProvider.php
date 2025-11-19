<?php

namespace App\Domain\Track;

use App\Domain\Search\Search;
use App\Domain\Search\SearchPerformer;
use App\Domain\Search\SeenTracksManager;
use App\Entity\Track;
use App\Repository\TrackRepository;
use Doctrine\ORM\EntityManagerInterface;

readonly class TrackProvider
{
    public function __construct(
        private TrackRepository $trackRepository,
        private SearchPerformer $searchPerformer,
        private SeenTracksManager $seenTracksManager,
        private EntityManagerInterface $em,
    ) {
    }

    /** @return Track[] */
    public function provide(Search $search): array
    {
        $this->em->getFilters()->enable('validated_entity');

        $tracks = $this->searchPerformer->search($search);

        $this->setSeenTracksIds($tracks);

        return $this->sortTracks($tracks);
    }

    /** @return Track[] */
    public function provideToModerate(): array
    {
        return $this->trackRepository->findToModerate();
    }

    /**
     * @param Track[] $tracks
     *
     * @return Track[]
     */
    public function sortTracks(array $tracks): array
    {
        shuffle($tracks);

        return $tracks;
    }

    /** @param Track[] $tracks */
    public function setSeenTracksIds(array $tracks): void
    {
        $tracksIds = array_map(fn (Track $track) => $track->getId(), $tracks);
        $this->seenTracksManager->add($tracksIds);
    }
}
