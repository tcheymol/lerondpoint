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
            ->leftJoin('t.tags', 'tg');

        return $this;
    }

    public function getQueryBuilder(): QueryBuilder
    {
        return $this->qb;
    }

    public function search(Search $search): self
    {
        return $this->searchText($search)
            ->searchKind($search)
            ->searchRegion($search)
            ->searchYear($search)
            ->searchLocation($search)
            ->searchTags($search)
            ->searchGroups($search);
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

    private function searchKind(Search $search): self
    {
        $kind = $search->kind;
        if ($kind) {
            $this->qb->andWhere('t.kind = :kind')
                ->setParameter('kind', $kind);
        }

        return $this;
    }

    private function searchRegion(Search $search): self
    {
        $region = $search->region;
        if ($region) {
            $this->qb->andWhere('t.region = :region')
                ->setParameter('region', $region->value);
        }

        return $this;
    }

    private function searchYear(Search $search): self
    {
        $year = $search->year;
        if ($year) {
            $this->qb->andWhere('t.year = :year')
                ->setParameter('year', $year);
        }

        return $this;
    }

    private function searchLocation(Search $search): self
    {
        $location = $search->location;
        if ($location) {
            $this->qb->andWhere('t.location LIKE :location')
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

    private function searchGroups(Search $search): self
    {
        $group = $search->group;
        if ($group) {
            $this->qb->andWhere('t.collective = :group')
                ->setParameter('group', $group);
        }

        return $this;
    }
}
