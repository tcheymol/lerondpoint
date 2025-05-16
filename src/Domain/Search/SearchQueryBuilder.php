<?php

namespace App\Domain\Search;

use App\Repository\TrackRepository;
use Doctrine\ORM\QueryBuilder;

class SearchQueryBuilder
{
    private QueryBuilder $qb;

    public function __construct(private readonly TrackRepository $trackRepository)
    {
    }

    public function init(): self
    {
        $this->qb = $this->trackRepository->createQueryBuilder('t')
            ->leftJoin('t.kind', 'k')
            ->leftJoin('t.collective', 'c')
            ->leftJoin('t.createdBy', 'u')
            ->leftJoin('t.tags', 'tg')
            ->leftJoin('t.regions', 'r')
            ->leftJoin('t.years', 'y');

        return $this;
    }

    public function getQueryBuilder(): QueryBuilder
    {
        return $this->qb;
    }

    public function search(Search $search): self
    {
        return $this->searchText($search)
            ->searchKinds($search)
            ->searchRegions($search)
            ->searchYear($search)
            ->searchLocations($search)
            ->searchTags($search)
            ->searchCollectives($search);
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
        $kinds = $search->kinds;
        if ($kinds->count() > 0) {
            $this->qb->andWhere('t.kind IN (:kinds)')
                ->setParameter('kinds', $kinds);
        }

        return $this;
    }

    private function searchRegions(Search $search): self
    {
        $regions = $search->regions;
        if ($regions->count() > 0) {
            $this->qb->andWhere('r.id IN (:regions)')
                ->setParameter('regions', $regions);
        }

        return $this;
    }

    private function searchYear(Search $search): self
    {
        $years = $search->years;
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
        $tags = $search->tags;
        if ($tags->count() > 0) {
            $this->qb->andWhere('tg.id IN (:tags)')
                ->setParameter('tags', $tags);
        }

        return $this;
    }

    private function searchCollectives(Search $search): self
    {
        $collectives = $search->collectives;
        if ($collectives->count() > 0) {
            $this->qb->andWhere('t.collective IN (:collectives)')
                ->setParameter('collectives', $collectives);
        }

        return $this;
    }
}
