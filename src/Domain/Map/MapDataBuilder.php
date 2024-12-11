<?php

namespace App\Domain\Map;

use App\Entity\Collective;
use App\Repository\CollectiveRepository;

readonly class MapDataBuilder
{
    public function __construct(private CollectiveRepository $collectiveRepository)
    {
    }

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
