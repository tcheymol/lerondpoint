<?php

namespace App\Domain\Search;

use App\Entity\Collective;
use App\Entity\Interface\PersistedEntityInterface;
use App\Entity\Region;
use App\Entity\TrackKind;
use App\Entity\TrackTag;
use App\Entity\Year;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

class Search
{
    /** @var Collection<int, TrackKind|PersistedEntityInterface> */
    public Collection $kinds;

    /** @var Collection<int, Collective|PersistedEntityInterface> */
    public Collection $collectives;

    /** @var Collection<int, TrackTag|PersistedEntityInterface> */
    public Collection $tags;

    /** @var Collection<int, Year|PersistedEntityInterface> */
    public Collection $years;

    /** @var Collection<int, Region|PersistedEntityInterface> */
    public Collection $regions;

    public function __construct(
        public ?bool $loadMore = false,
        public ?string $text = null,
        public ?string $location = null,
        public string $sortBy = 'random',
    ) {
        $this->tags = new ArrayCollection();
        $this->kinds = new ArrayCollection();
        $this->collectives = new ArrayCollection();
        $this->years = new ArrayCollection();
        $this->regions = new ArrayCollection();
    }

    /** @return array<string, string> */
    public function toParamsArray(): array
    {
        $params = array_filter([
            'q'        => $this->text,
            'location' => $this->location,
        ]);

        $params['sortBy'] = $this->sortBy;

        foreach (['kinds', 'tags', 'regions', 'years', 'collectives'] as $field) {
            $ids = self::collectionToIdsString($this->$field);
            if ('' !== $ids) {
                $params[$field] = $ids;
            }
        }

        return $params;
    }

    public function setQ(?string $q): self
    {
        $this->text = $q;

        return $this;
    }

    public function isEmpty(): bool
    {
        return
            !$this->text
            && !$this->location
            && 0 === $this->tags->count()
            && 0 === $this->kinds->count()
            && 0 === $this->regions->count()
            && 0 === $this->years->count()
            && 0 === $this->collectives->count();
    }

    /**
     * @param Collection<int, PersistedEntityInterface> $collection
     *
     * @return (int|null)[]
     */
    public static function collectionToIdsArray(Collection $collection): array
    {
        return $collection
            ->map(fn (PersistedEntityInterface $entity) => $entity->getId())
            ->filter(fn (?int $id) => null !== $id)
            ->toArray();
    }

    /**
     * @param Collection<int, PersistedEntityInterface> $collection
     */
    public static function collectionToIdsString(Collection $collection): string
    {
        return implode(',', self::collectionToIdsArray($collection));
    }
}
