<?php

namespace App\Domain\Search;

use App\Entity\Track;

readonly class SearchPerformer
{
    public const int NUMBER_PER_PAGE = 50;

    public function __construct(private SearchQueryBuilder $queryBuilder)
    {
    }

    /** @return Track[] */
    public function search(Search $search): array
    {
        return $this->queryBuilder
            ->init()
            ->search($search)
            ->getQueryBuilder()
            ->addSelect('RANDOM() as HIDDEN random')
            ->orderBy('random()')
            ->setMaxResults(self::NUMBER_PER_PAGE)
            ->getQuery()
            ->getResult();
    }
}
