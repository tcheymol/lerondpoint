<?php

namespace App\Domain\Search;

use App\Domain\Location\Region;
use App\Repository\CollectiveRepository;
use App\Repository\TrackKindRepository;
use App\Repository\TrackTagRepository;
use Symfony\Component\PropertyAccess\PropertyAccessor;

readonly class SearchFactory
{
    private PropertyAccessor $propertyAccessor;

    public function __construct(
        private TrackTagRepository $trackTagRepository,
        private TrackKindRepository $trackKindRepository,
        private CollectiveRepository $collectiveRepository,
    ) {
        $this->propertyAccessor = new PropertyAccessor();
    }

    /** @param array<string, array<string, mixed>|bool|float|int|string> $params */
    public function create(array $params): Search
    {
        $search = new Search();

        foreach ($params as $key => $value) {
            if ('tags' === $key && is_string($value)) {
                foreach (explode(',', $value) as $id) {
                    $tag = $this->trackTagRepository->find((int) $id);
                    if ($tag) {
                        $search->tags->add($tag);
                    }
                }
            } elseif ('kind' === $key) {
                $search->kind = $this->trackKindRepository->find((int) $value);
            } elseif ('group' === $key) {
                $search->group = $this->collectiveRepository->find((int) $value);
            } elseif ('region' === $key && is_string($value)) {
                $search->region = Region::from($value);
            } elseif (!is_array($value)) {
                $this->propertyAccessor->setValue($search, $key, (string) $value);
            }
        }

        return $search;
    }
}
