<?php

namespace App\Entity;

use App\Domain\Location\RegionEnum as EnumRegion;
use App\Entity\Interface\BlameableInterface;
use App\Entity\Trait\BlameableTrait;
use App\Repository\TrackRepository;
use App\Validator\AttachmentOrUrl;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\Order;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TrackRepository::class)]
#[AttachmentOrUrl]
class Track implements BlameableInterface
{
    use BlameableTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\ManyToOne(targetEntity: Collective::class, fetch: 'EAGER', inversedBy: 'tracks')]
    private ?Collective $collective = null;

    #[ORM\ManyToOne(inversedBy: 'tracks')]
    private ?TrackKind $kind = null;

    /** @var Collection<int, TrackTag> */
    #[ORM\ManyToMany(targetEntity: TrackTag::class, inversedBy: 'tracks')]
    #[ORM\OrderBy(['name' => Order::Ascending->value])]
    private Collection $tags;

    /** @var Collection<int, Attachment> */
    #[ORM\OneToMany(
        targetEntity: Attachment::class,
        mappedBy: 'track',
        cascade: ['persist', 'remove'],
        orphanRemoval: true,
    )]
    private Collection $attachments;

    /** @var string[] */
    public array $attachmentsIds = [];

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(nullable: true)]
    private ?int $year = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $location = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?EnumRegion $region = null;

    public ?string $url = null;

    #[ORM\Column(nullable: true)]
    private ?bool $isDraft = true;

    #[ORM\ManyToOne(inversedBy: 'tracks')]
    private ?User $createdBy = null;

    #[ORM\Column(nullable: true)]
    private ?bool $hasFaces = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $email = null;

    #[ORM\ManyToOne]
    private ?RejectionCause $rejectionCause = null;

    #[ORM\Column(nullable: true)]
    private ?int $creationStep = null;

    /**
     * @var Collection<int, Year>
     */
    #[ORM\ManyToMany(targetEntity: Year::class, inversedBy: 'tracks')]
    private Collection $years;

    /**
     * @var Collection<int, Region>
     */
    #[ORM\ManyToMany(targetEntity: Region::class, inversedBy: 'tracks')]
    private Collection $regions;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?Attachment $coverAttachment = null;

    public function __construct()
    {
        $this->tags = new ArrayCollection();
        $this->attachments = new ArrayCollection();
        $this->years = new ArrayCollection();
        $this->regions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getCollectiveName(): ?string
    {
        return $this->collective?->getName();
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

    public function getKindName(): ?string
    {
        return $this->kind?->getName();
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

    public function getTagsAsString(): string
    {
        return implode(',', $this->tags->map(fn (TrackTag $tag) => $tag->getName())->toArray());
    }

    /** @return Collection<int, TrackTag> */
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

    /** @return Collection<int, Attachment> */
    public function getAttachments(): Collection
    {
        return $this->attachments;
    }

    public function addAttachment(?Attachment $attachment): static
    {
        if ($attachment && !$this->attachments->contains($attachment)) {
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

    public function countAttachments(): int
    {
        return $this->attachments->count();
    }

    public function hasMultipleAttachments(): bool
    {
        return $this->countAttachments() > 1;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getYear(): ?int
    {
        return $this->year;
    }

    public function setYear(?int $year): static
    {
        $this->year = $year;

        return $this;
    }

    public function getLocation(): ?string
    {
        return $this->location;
    }

    public function setLocation(?string $location): static
    {
        $this->location = $location;

        return $this;
    }

    public function getRegionName(): ?string
    {
        return $this->region?->value;
    }

    public function getRegion(): ?EnumRegion
    {
        return $this->region;
    }

    public function setRegion(EnumRegion $region): static
    {
        $this->region = $region;

        return $this;
    }

    public function getMediaType(): ?string
    {
        if ('application/pdf' === $this->getMime()) {
            return 'pdf';
        }

        return $this->url ? 'video' : 'image';
    }

    public function isPdf(): bool
    {
        return 'pdf' === $this->getMediaType();
    }

    public function getMime(): ?string
    {
        return $this->getCover()?->getKind() ?: null;
    }

    public function isDraft(): ?bool
    {
        return $this->isDraft;
    }

    public function setDraft(?bool $isDraft): static
    {
        $this->isDraft = $isDraft;

        return $this;
    }

    public function publish(): void
    {
        $this->isDraft = false;
    }

    public function needsModeration(): bool
    {
        return !$this->isDraft && !$this->rejected && !$this->validated;
    }

    public function getPreviewUrl(): ?string
    {
        return $this->getCover()?->getPreviewUrl();
    }

    public function getVideoEmbed(): ?string
    {
        return $this->getCover()?->getVideoEmbed();
    }

    public function isVideo(): bool
    {
        return null !== $this->getPreviewUrl();
    }

    public function hasAttachments(): bool
    {
        return $this->getAttachments()->count() > 0;
    }

    public function hasFaces(): ?bool
    {
        return $this->hasFaces;
    }

    public function setHasFaces(?bool $hasFaces): static
    {
        $this->hasFaces = $hasFaces;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getContactEmail(): ?string
    {
        if ($this->createdBy?->getEmail()) {
            return $this->createdBy->getEmail();
        }

        return $this->email;
    }

    public function getRejectionCause(): ?RejectionCause
    {
        return $this->rejectionCause;
    }

    public function setRejectionCause(?RejectionCause $rejectionCause): static
    {
        $this->rejectionCause = $rejectionCause;

        return $this;
    }

    public function getCreationStep(): ?int
    {
        return $this->creationStep;
    }

    public function setCreationStep(?int $creationStep): static
    {
        $this->creationStep = $creationStep;

        return $this;
    }

    public function bumpCreationStep(?int $creationStep = 0): static
    {
        if (null === $this->creationStep || $this->creationStep < $creationStep) {
            $this->creationStep = $creationStep;
        }

        return $this;
    }

    /** @return Collection<int, Year> */
    public function getYears(): Collection
    {
        return $this->years;
    }

    public function addYear(Year $year): static
    {
        if (!$this->years->contains($year)) {
            $this->years->add($year);
        }

        return $this;
    }

    public function removeYear(Year $year): static
    {
        $this->years->removeElement($year);

        return $this;
    }

    public function getYearsAsString(): string
    {
        return implode(', ', $this->years->map(fn (Year $year) => (string) $year)->toArray());
    }

    /** @return Collection<int, Region> */
    public function getRegions(): Collection
    {
        return $this->regions;
    }

    public function addRegion(Region $region): static
    {
        if (!$this->regions->contains($region)) {
            $this->regions->add($region);
        }

        return $this;
    }

    public function removeRegion(Region $region): static
    {
        $this->regions->removeElement($region);

        return $this;
    }

    public function getRegionsAsString(): string
    {
        return implode(', ', $this->regions->map(fn (Region $region) => (string) $region)->toArray());
    }

    public function getCover(): ?Attachment
    {
        if ($this->coverAttachment) {
            return $this->coverAttachment;
        }

        return $this->attachments->first() ?: null;
    }

    public function getCoverAttachment(): ?Attachment
    {
        return $this->coverAttachment;
    }

    public function setCoverAttachment(?Attachment $coverAttachment): static
    {
        $this->coverAttachment = $coverAttachment;

        return $this;
    }
}
