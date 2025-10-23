<?php

namespace App\Domain\Search;

use App\Entity\Track;

readonly class SearchPerformer
{
    public function __construct(private SearchQueryBuilder $queryBuilder)
    {
    }

    /** @return Track[] */
    public function search(Search $search): array
    {
        return $this->queryBuilder
            ->init()
            ->search($search)
            ->selectRandoms()
            ->limit()
            ->getResults();
    }
}
