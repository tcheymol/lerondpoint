<?php

namespace App\Domain\Track;

use App\Entity\Track;
use App\Repository\TrackKindRepository;

readonly class TrackKindProvider
{
    public function __construct(private TrackKindRepository $repository)
    {
    }

    /** @return array<Track> */
    public function provide(): array {
        return $this->repository->findAll();
    }
}
