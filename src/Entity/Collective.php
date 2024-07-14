<?php

namespace App\Entity;

use App\Entity\Trait\DisableTrait;
use App\Entity\Trait\ValidatedTrait;
use App\Repository\CollectiveRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Blameable\Traits\Blameable;
use Gedmo\SoftDeleteable\Traits\SoftDeleteable;
use Gedmo\Timestampable\Traits\TimestampableEntity;

#[ORM\Entity(repositoryClass: CollectiveRepository::class)]
class Collective
{
    use TimestampableEntity;
    use Blameable;
    use SoftDeleteable;
    use DisableTrait;
    use ValidatedTrait;
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?bool $enabled = null;

    /**
     * @var Collection<int, Action>
     */
    #[ORM\OneToMany(targetEntity: Action::class, mappedBy: 'collective')]
    private Collection $actions;

    /**
     * @var Collection<int, Track>
     */
    #[ORM\OneToMany(targetEntity: Track::class, mappedBy: 'collective')]
    private Collection $tracks;

    public function __construct()
    {
        $this->actions = new ArrayCollection();
        $this->tracks = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function isEnabled(): ?bool
    {
        return $this->enabled;
    }

    public function setEnabled(bool $enabled): static
    {
        $this->enabled = $enabled;

        return $this;
    }

    /**
     * @return Collection<int, Action>
     */
    public function getActions(): Collection
    {
        return $this->actions;
    }

    public function addAction(Action $action): static
    {
        if (!$this->actions->contains($action)) {
            $this->actions->add($action);
            $action->setCollective($this);
        }

        return $this;
    }

    public function removeAction(Action $action): static
    {
        if ($this->actions->removeElement($action)) {
            // set the owning side to null (unless already changed)
            if ($action->getCollective() === $this) {
                $action->setCollective(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Track>
     */
    public function getTracks(): Collection
    {
        return $this->tracks;
    }

    public function addTrack(Track $track): static
    {
        if (!$this->tracks->contains($track)) {
            $this->tracks->add($track);
            $track->setCollective($this);
        }

        return $this;
    }

    public function removeTrack(Track $track): static
    {
        if ($this->tracks->removeElement($track)) {
            // set the owning side to null (unless already changed)
            if ($track->getCollective() === $this) {
                $track->setCollective(null);
            }
        }

        return $this;
    }
}
