<?php

namespace App\Domain\Map;

use App\Entity\Collective;
use App\Repository\CollectiveRepository;

readonly class MapDataBuilder
{
    public function __construct(private CollectiveRepository $collectiveRepository)
    {
    }

    /** @return array{lat: ?float, lon: ?float, name: ?string}[] */
    public function build(): array
    {
        return array_map(
            fn (Collective $collective) => [
                'lat' => $collective->getLat(),
                'lon' => $collective->getLon(),
                'name' => $collective->getName(),
            ],
            $this->collectiveRepository->findAll()
        );
    }
}
