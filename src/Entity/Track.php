<?php

namespace App\Entity;

use App\Domain\Images\ThumbSize;
use App\Domain\Location\Region;
use App\Entity\Interface\BlameableInterface;
use App\Entity\Trait\BlameableTrait;
use App\Repository\TrackRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TrackRepository::class)]
class Track implements BlameableInterface
{
    use BlameableTrait;

    public const string YOUTUBE_PREVIEW_URL_SCHEME = 'https://img.youtube.com/vi/%s/hqdefault.jpg';
    public const string YOUTUBE_EMBED_URL_SCHEME = 'https://www.youtube.com/embed/%s';

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\ManyToOne(inversedBy: 'tracks')]
    private ?Collective $collective = null;

    #[ORM\ManyToOne(inversedBy: 'tracks')]
    private ?TrackKind $kind = null;

    /** @var Collection<int, TrackTag> */
    #[ORM\ManyToMany(targetEntity: TrackTag::class, inversedBy: 'tracks')]
    private Collection $tags;

    /** @var Collection<int, Attachment> */
    #[ORM\OneToMany(
        targetEntity: Attachment::class,
        mappedBy: 'track',
        cascade: ['persist', 'remove'],
        //        orphanRemoval: true,
    )]
    private Collection $attachments;

    /** @var string[] */
    public array $attachmentsIds = [];

    #[ORM\Column(nullable: true)]
    private ?float $lat = null;

    #[ORM\Column(nullable: true)]
    private ?float $lng = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(nullable: true)]
    private ?int $year = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $location = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?Region $region = null;

    #[ORM\Column(length: 2083, nullable: true)]
    private ?string $url = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $rejectionCause = null;

    public ?int $previousTrackId = null;
    public ?int $nextTrackId = null;

    #[ORM\Column(nullable: true)]
    private ?bool $isDraft = true;

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

    public function setName(?string $name): static
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

    public function getLat(): ?float
    {
        return $this->lat;
    }

    public function setLat(?float $lat): static
    {
        $this->lat = $lat;

        return $this;
    }

    public function getLng(): ?float
    {
        return $this->lng;
    }

    public function setLng(?float $lng): static
    {
        $this->lng = $lng;

        return $this;
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

    public function getRegion(): ?Region
    {
        return $this->region;
    }

    public function setRegion(Region $region): static
    {
        $this->region = $region;

        return $this;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(?string $url): static
    {
        $this->url = $url;

        return $this;
    }

    private function getVideoIdFromYoutubeUrl(): ?string
    {
        if (!$this->url) {
            return null;
        }

        /** @var array<string, string> $url_components */
        $url_components = parse_url($this->url);
        parse_str($url_components['query'], $params);

        $videoId = $params['v'];

        if (!is_array($videoId)) {
            return $videoId;
        }

        return null;
    }

    private function buildYoutubeUrl(string $urlScheme): ?string
    {
        $videoId = $this->getVideoIdFromYoutubeUrl();

        return !$videoId ? null : sprintf($urlScheme, $videoId);
    }

    public function getVideoPreview(): ?string
    {
        return $this->buildYoutubeUrl(self::YOUTUBE_PREVIEW_URL_SCHEME);
    }

    public function getVideoEmbed(): ?string
    {
        return $this->buildYoutubeUrl(self::YOUTUBE_EMBED_URL_SCHEME);
    }

    public function getObjectUrl(): ?string
    {
        if ($this->url) {
            return $this->getVideoPreview();
        }

        return $this->getThumbnailUrl(ThumbSize::Full);
    }

    public function getThumbnailUrl(?ThumbSize $thumbSize = null): ?string
    {
        if ($this->url) {
            return $this->getVideoPreview();
        }

        return $this->attachments
            ->findFirst(fn (int $key, Attachment $attachment): bool => null !== $attachment->getBestFitUrl($thumbSize))
            ?->getBestFitUrl($thumbSize);
    }

    public function getMediaType(): ?string
    {
        if ('application/pdf' === $this->getMime()) {
            return 'pdf';
        }

        return $this->url ? 'video' : 'image';
    }

    public function getMime(): ?string
    {
        return $this->attachments
            ->findFirst(fn (int $key, Attachment $attachment): bool => null !== $attachment->getKind())
            ?->getKind();
    }

    public function getRejectionCause(): ?string
    {
        return $this->rejectionCause;
    }

    public function setRejectionCause(?string $rejectionCause): static
    {
        $this->rejectionCause = $rejectionCause;

        return $this;
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
}
