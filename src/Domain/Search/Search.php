<?php

namespace App\Domain\Search;

use App\Domain\Location\Region;
use App\Entity\Collective;
use App\Entity\TrackKind;
use App\Entity\TrackTag;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

class Search
{
    public ?TrackKind $kind = null;
    public ?Collective $group = null;

    /** @var Collection<int, TrackTag> */
    public Collection $tags;

    /** @var array<string, string> */
    private array $params = [];

    public function __construct(
        public ?string $text = null,
        public ?Region $region = null,
        public ?int $year = null,
        public ?string $location = null,
    ) {
        $this->tags = new ArrayCollection();
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
        if ($this->kind) {
            $this->params['kind'] = (string) $this->kind->getId();
        }

        return $this;
    }

    private function addRegionParam(): self
    {
        if ($this->region) {
            $this->params['region'] = $this->region->value;
        }

        return $this;
    }

    private function addYearParam(): self
    {
        if ($this->year) {
            $this->params['year'] = (string) $this->year;
        }

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
        $this->params['tags'] = implode(',', $this->tags->map(fn (TrackTag $tag) => (string) $tag->getId())->toArray());

        return $this;
    }

    private function addCollectiveParam(): self
    {
        if ($this->group) {
            $this->params['group'] = (string) $this->group->getId();
        }

        return $this;
    }

    public function isEmpty(): bool
    {
        return
            !$this->text
            && !$this->region
            && !$this->year
            && !$this->location
            && !$this->kind
            && !$this->group
            && 0 === $this->tags->count();
    }
}
