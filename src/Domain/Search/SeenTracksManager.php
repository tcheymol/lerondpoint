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

    /** @param int[] $ids */
    public function set(array $ids): void
    {
        $this->setItem('seen_tracks', $ids);
    }

    public function get(): mixed
    {
        return $this->getItem('seen_tracks', []);
    }

    /** @param array<int|null> $ids */
    public function add(array $ids = []): void
    {
        /** @var int[] $seenTracksIds */
        $seenTracksIds = $this->getItem('seen_tracks', []);
        $cleanedSeenTracksIds = array_filter(
            array_map(intval(...), $seenTracksIds),
            fn (?int $id) => 0 !== $id,
        );
        $nonNullIds = array_filter($ids, fn (?int $id) => null !== $id);

        $this->set(array_unique([...$cleanedSeenTracksIds, ...$nonNullIds]));
    }

    public function reset(): void
    {
        $this->setItem('seen_tracks', []);
    }
}
