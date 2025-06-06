<?php

namespace App\Domain\Track;

use App\Domain\Search\Search;
use App\Domain\Search\SearchPerformer;
use App\Entity\Track;
use App\Repository\TrackRepository;
use Doctrine\ORM\EntityManagerInterface;

readonly class TrackProvider
{
    public function __construct(
        private TrackRepository $trackRepository,
        private SearchPerformer $searchPerformer,
        private EntityManagerInterface $em,
    ) {
    }

    /** @return array<Track> */
    public function provide(Search $search): array
    {
        $this->em->getFilters()->enable('validated_entity');

        return $search->isEmpty()
            ? $this->trackRepository->findAll()
            : $this->searchPerformer->search($search);
    }

    /** @return Track[] */
    public function provideToModerate(): array
    {
        return $this->trackRepository->findToModerate();
    }
}
