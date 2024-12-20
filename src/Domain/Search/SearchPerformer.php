<?php

namespace App\Domain\Search;

use App\Entity\Track;
use Doctrine\ORM\QueryBuilder;

readonly class SearchPerformer
{
    public function __construct(private SearchQueryBuilder $queryBuilder)
    {
    }

    /** @return Track[] */
    public function perform(Search $search): array
    {
        $qb = $this->queryBuilder
            ->init()
            ->search($search)
            ->getQueryBuilder();

        return $this->getResult($qb);
    }

    /** @return Track[] */
    private function getResult(QueryBuilder $qb): array
    {
        /** @var Track[] $tracks */
        $tracks = $qb->getQuery()->getResult();

        return $tracks;
    }
}
