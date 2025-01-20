<?php

namespace App\Domain\Map;

use App\Entity\Action;
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
                'id' => $collective->getId(),
                'lat' => $collective->getLat(),
                'lon' => $collective->getLon(),
                'name' => $collective->getName(),
                'iconPath' => $collective->getIconPath(),
                'shortDescription' => $collective->getShortDescription(),
                'followUs' => $collective->getFollowUs(),
                'description' => $collective->getDescription(),
                'actions' => $collective->getActions()->map(
                    fn (Action $action) => ['name' => $action->getName(), 'iconPath' => $action->getIconPublicPath()]
                )->toArray(),
            ],
            $this->collectiveRepository->findAll()
        );
    }
}
