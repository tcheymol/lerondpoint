<?php

namespace App\Domain\Search;

use App\Domain\Security\SessionAwareTrait;
use Symfony\Component\HttpFoundation\RequestStack;

readonly class SeenTracksManager
{
    use SessionAwareTrait;

    public function __construct(private RequestStack $requestStack)
    {
    }

    public function set(array $ids): void
    {
        $this->setItem('seen_tracks', $ids);
    }

    /** @return int[] */
    public function get(): array
    {
        return $this->getItem('seen_tracks', []);
    }

    public function add(array $ids = []): void
    {
        $alreadySeenTracks = $this->getItem('seen_tracks', []);

        $this->set(array_unique([...$alreadySeenTracks, ...$ids]));
    }

    public function reset(): void
    {
        $this->setItem('seen_tracks', []);
    }
}
