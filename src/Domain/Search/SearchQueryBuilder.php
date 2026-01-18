<?php

namespace App\Domain\Search;

use App\Entity\Interface\PersistedEntityInterface;
use App\Entity\Track;
use App\Repository\TrackRepository;
use Doctrine\ORM\QueryBuilder;

class SearchQueryBuilder
{
    public const int NUMBER_PER_PAGE = 16;
    private QueryBuilder $qb;

    public function __construct(private readonly TrackRepository $trackRepository, private readonly SeenTracksManager $seenTracksManager)
    {
    }

    public function init(): self
    {
        $this->qb = $this->trackRepository->createQueryBuilder('t')
            ->select('DISTINCT t')
            ->leftJoin('t.kind', 'k')
            ->leftJoin('t.collective', 'c')
            ->leftJoin('t.createdBy', 'u')
            ->leftJoin('t.tags', 'tg')
            ->leftJoin('t.regions', 'r')
            ->leftJoin('t.years', 'y');

        return $this;
    }

    public function search(Search $search): self
    {
        return $this->searchText($search)
            ->searchKinds($search)
            ->searchRegions($search)
            ->searchYear($search)
            ->searchLocations($search)
            ->searchTags($search)
            ->searchCollectives($search)
            ->excludeIds($search->loadMore);
    }

    public function selectRandoms(): self
    {
        $this->qb
            ->addSelect('RANDOM() as HIDDEN random')
            ->orderBy('random()')
            ->addGroupBy('t.id')
        ;

        return $this;
    }

    public function limit(): self
    {
        $this->qb->setMaxResults(self::NUMBER_PER_PAGE);

        return $this;
    }

    /** @return Track[] */
    public function getResults(): array
    {
        /** @var Track[] $results */
        $results = $this->qb->getQuery()->getResult();

        return $results;
    }

    private function searchText(Search $search): self
    {
        $text = $search->text;
        if ($text) {
            $this->qb->andWhere('
                  t.name LIKE :searchText
                OR t.description LIKE :searchText
                OR t.location LIKE :searchText
                OR t.region LIKE :searchText
                OR t.year LIKE :searchText
                OR k.name LIKE :searchText
                OR c.name LIKE :searchText
                OR u.email LIKE :searchText
                OR tg.name LIKE :searchText
            ')
            ->setParameter('searchText', "%$text%");
        }

        return $this;
    }

    private function searchKinds(Search $search): self
    {
        $kinds = $search->kinds->filter(fn (?PersistedEntityInterface $kind) => null !== $kind);
        if ($kinds->count() > 0) {
            $this->qb->andWhere('t.kind IN (:kinds)')
                ->setParameter('kinds', $kinds);
        }

        return $this;
    }

    private function searchRegions(Search $search): self
    {
        $regions = $search->regions->filter(fn (?PersistedEntityInterface $region) => null !== $region);
        if ($regions->count() > 0) {
            $this->qb->andWhere('r.id IN (:regions)')
                ->setParameter('regions', $regions);
        }

        return $this;
    }

    private function searchYear(Search $search): self
    {
        $years = $search->years->filter(fn (?PersistedEntityInterface $year) => null !== $year);
        if ($years->count() > 0) {
            $this->qb->andWhere('y.id IN (:years)')
                ->setParameter('years', $years);
        }

        return $this;
    }

    private function searchLocations(Search $search): self
    {
        $location = $search->location;
        if ($location) {
            $this->qb->andWhere('l.id LIKE :location')
                ->setParameter('location', "%$location%");
        }

        return $this;
    }

    private function searchTags(Search $search): self
    {
        $tags = $search->tags->filter(fn (?PersistedEntityInterface $tag) => null !== $tag);
        if ($tags->count() > 0) {
            $this->qb->andWhere('tg.id IN (:tags)')
                ->setParameter('tags', $tags);
        }

        return $this;
    }

    private function searchCollectives(Search $search): self
    {
        $collectives = $search->collectives->filter(fn (?PersistedEntityInterface $collectives) => null !== $collectives);
        if ($collectives->count() > 0) {
            $this->qb->andWhere('t.collective IN (:collectives)')
                ->setParameter('collectives', $collectives);
        }

        return $this;
    }

    private function excludeIds(?bool $loadMore = false): self
    {
        $seenTracksIds = $this->seenTracksManager->get();
        if (!$seenTracksIds || !$loadMore) {
            return $this;
        }

        $this->qb->andWhere('t.id NOT IN (:excludeIds)')
            ->setParameter('excludeIds', $seenTracksIds);

        return $this;
    }
}
