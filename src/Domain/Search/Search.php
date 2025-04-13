<?php

namespace App\Domain\Search;

use App\Domain\Location\Region;
use App\Entity\Collective;
use App\Entity\Interface\PersistedEntityInterface;
use App\Entity\TrackKind;
use App\Entity\TrackTag;
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

    /** @var array<int, string> */
    public array $years;

    /** @var array<int, Region> */
    public array $regions;

    /** @var array<string, string> */
    private array $params = [];

    public function __construct(
        public ?string $text = null,
        public ?string $location = null,
    ) {
        $this->tags = new ArrayCollection();
        $this->kinds = new ArrayCollection();
        $this->collectives = new ArrayCollection();
        $this->years = [];
        $this->regions = [];
    }

    /** @return array<string, string> */
    public function toParamsArray(): array
    {
        return $this
            ->addTextParam()
            ->addKindParam()
            ->addRegionParam()
            ->addYearParam()
            ->addLocationParam()
            ->addTagsParam()
            ->addCollectiveParam()
            ->params;
    }

    private function addTextParam(): self
    {
        if ($this->text) {
            $this->params['q'] = $this->text;
        }

        return $this;
    }

    public function setQ(?string $q): self
    {
        $this->text = $q;

        return $this;
    }

    private function addKindParam(): self
    {
        $this->params['kinds'] = self::collectionToIdsString($this->kinds);

        return $this;
    }

    private function addRegionParam(): self
    {
        $this->params['regions'] = implode(',',
            array_map(
                fn (Region $region) => $region->value,
                $this->regions
            )
        );

        return $this;
    }

    private function addYearParam(): self
    {
        $this->params['years'] = implode(',', $this->years);

        return $this;
    }

    private function addLocationParam(): self
    {
        if ($this->location) {
            $this->params['location'] = $this->location;
        }

        return $this;
    }

    private function addTagsParam(): self
    {
        $this->params['tags'] = self::collectionToIdsString($this->tags);

        return $this;
    }

    private function addCollectiveParam(): self
    {
        $this->params['collectives'] = self::collectionToIdsString($this->collectives);

        return $this;
    }

    public function isEmpty(): bool
    {
        return
            !$this->text
            && !$this->location
            && 0 === $this->tags->count()
            && 0 === $this->kinds->count()
            && 0 === count($this->regions)
            && 0 === count($this->years)
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
