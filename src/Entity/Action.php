<?php

namespace App\Entity;

use App\Entity\Trait\BlameableTrait;
use App\Repository\ActionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ActionRepository::class)]
class Action
{
    use BlameableTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\ManyToOne]
    private ?ActionKind $kind = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?ActionTag $tags = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 2, scale: 0, nullable: true)]
    private ?string $coordinatesX = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 5, scale: 2, nullable: true)]
    private ?string $coordinatesY = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $notes = null;

    /**
     * @var Collection<int, Attachment>
     */
    #[ORM\OneToMany(targetEntity: Attachment::class, mappedBy: 'action')]
    private Collection $attachments;

    #[ORM\ManyToOne(inversedBy: 'actions')]
    private ?Collective $collective = null;

    public function __construct()
    {
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

    public function getKind(): ?ActionKind
    {
        return $this->kind;
    }

    public function setKind(?ActionKind $kind): static
    {
        $this->kind = $kind;

        return $this;
    }

    public function getTags(): ?ActionTag
    {
        return $this->tags;
    }

    public function setTags(?ActionTag $tags): static
    {
        $this->tags = $tags;

        return $this;
    }

    public function getCoordinatesX(): ?string
    {
        return $this->coordinatesX;
    }

    public function setCoordinatesX(?string $coordinatesX): static
    {
        $this->coordinatesX = $coordinatesX;

        return $this;
    }

    public function getCoordinatesY(): ?string
    {
        return $this->coordinatesY;
    }

    public function setCoordinatesY(?string $coordinatesY): static
    {
        $this->coordinatesY = $coordinatesY;

        return $this;
    }

    public function getNotes(): ?string
    {
        return $this->notes;
    }

    public function setNotes(?string $notes): static
    {
        $this->notes = $notes;

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
            $attachment->setAction($this);
        }

        return $this;
    }

    public function removeAttachment(Attachment $attachment): static
    {
        if ($this->attachments->removeElement($attachment)) {
            // set the owning side to null (unless already changed)
            if ($attachment->getAction() === $this) {
                $attachment->setAction(null);
            }
        }

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
}
