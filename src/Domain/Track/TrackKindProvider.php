<?php

namespace App\Domain\Track;

use App\Entity\TrackKind;
use App\Repository\TrackKindRepository;

readonly class TrackKindProvider
{
    public function __construct(private TrackKindRepository $repository)
    {
    }

    /** @return TrackKind[] */
    public function provide(): array
    {
        return $this->repository->findAll();
    }
}
