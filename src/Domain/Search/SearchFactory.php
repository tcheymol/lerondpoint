<?php

namespace App\Domain\Search;

use App\Repository\CollectiveRepository;
use App\Repository\RegionRepository;
use App\Repository\TrackKindRepository;
use App\Repository\TrackTagRepository;
use App\Repository\YearRepository;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\PropertyAccess\PropertyAccessor;

readonly class SearchFactory
{
    private PropertyAccessor $propertyAccessor;

    /** @var array<string, ServiceEntityRepository> */
    private array $repositories;

    public function __construct(
        TrackTagRepository $trackTagRepository,
        TrackKindRepository $trackKindRepository,
        CollectiveRepository $collectiveRepository,
        YearRepository $yearRepository,
        RegionRepository $regionRepository,
    ) {
        $this->propertyAccessor = new PropertyAccessor();
        $this->repositories = [
            'tags' => $trackTagRepository,
            'kinds' => $trackKindRepository,
            'collectives' => $collectiveRepository,
            'regions' => $regionRepository,
            'years' => $yearRepository,
        ];
    }

    /** @param array<string, array<string, mixed>|bool|float|int|string> $params */
    public function create(array $params): Search
    {
        $search = new Search();

        foreach ($params as $key => $value) {
            if (in_array($key, ['tags', 'kinds', 'collectives', 'regions', 'years']) && is_string($value)) {
                $entities = $this->idsStringToEntityCollection($key, $value);
                match ($key) {
                    'tags' => $search->tags = $entities,
                    'kinds' => $search->kinds = $entities,
                    'collectives' => $search->collectives = $entities,
                    'regions' => $search->regions = $entities,
                    'years' => $search->years = $entities,
                };
            } elseif (!is_array($value)) {
                $this->propertyAccessor->setValue($search, $key, (string) $value);
            }
        }

        return $search;
    }

    private function idsStringToEntityCollection(string $key, string $stringValue): Collection
    {
        return new ArrayCollection(array_map(
            fn (string $id) => $this->repositories[$key]->find((int) $id),
            explode(',', $stringValue)
        ));
    }
}
