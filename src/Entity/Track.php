<?php

namespace App\Entity;

use App\Entity\Trait\DisableTrait;
use App\Entity\Trait\ValidatedTrait;
use App\Repository\TrackRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Blameable\Traits\Blameable;
use Gedmo\SoftDeleteable\Traits\SoftDeleteable;
use Gedmo\Timestampable\Traits\TimestampableEntity;

#[ORM\Entity(repositoryClass: TrackRepository::class)]
class Track
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

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\ManyToOne(inversedBy: 'tracks')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Collective $collective = null;

    #[ORM\ManyToOne(inversedBy: 'tracks')]
    private ?TrackKind $kind = null;

    /**
     * @var Collection<int, TrackTag>
     */
    #[ORM\ManyToMany(targetEntity: TrackTag::class, inversedBy: 'tracks')]
    private Collection $tags;

    /**
     * @var Collection<int, Attachment>
     */
    #[ORM\OneToMany(targetEntity: Attachment::class, mappedBy: 'track')]
    private Collection $attachments;

    public function __construct()
    {
        $this->tags = new ArrayCollection();
        $this->attachments = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getCollective(): ?Collective
    {
        return $this->collective;
    }

    public function setCollective(?Collective $collective): static
    {
        $this->collective = $collective;

        return $this;
    }

    public function getKind(): ?TrackKind
    {
        return $this->kind;
    }

    public function setKind(?TrackKind $kind): static
    {
        $this->kind = $kind;

        return $this;
    }

    /**
     * @return Collection<int, TrackTag>
     */
    public function getTags(): Collection
    {
        return $this->tags;
    }

    public function addTag(TrackTag $tag): static
    {
        if (!$this->tags->contains($tag)) {
            $this->tags->add($tag);
        }

        return $this;
    }

    public function removeTag(TrackTag $tag): static
    {
        $this->tags->removeElement($tag);

        return $this;
    }

    /**
     * @return Collection<int, Attachment>
     */
    public function getAttachments(): Collection
    {
        return $this->attachments;
    }

    public function addAttachment(Attachment $attachment): static
    {
        if (!$this->attachments->contains($attachment)) {
            $this->attachments->add($attachment);
            $attachment->setTrack($this);
        }

        return $this;
    }

    public function removeAttachment(Attachment $attachment): static
    {
        if ($this->attachments->removeElement($attachment)) {
            // set the owning side to null (unless already changed)
            if ($attachment->getTrack() === $this) {
                $attachment->setTrack(null);
            }
        }

        return $this;
    }
}