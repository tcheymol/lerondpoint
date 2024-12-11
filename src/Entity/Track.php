<?php

phpinfo();

namespace App\Entity;

use App\Domain\Location\Region;
use App\Entity\Inteface\BlameableInterface;
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

    /**
     * @var Collection<int, TrackTag>
     */
    #[ORM\ManyToMany(targetEntity: TrackTag::class, inversedBy: 'tracks')]
    private Collection $tags;

    /** @var Collection<int, Attachment> */
    #[ORM\OneToMany(targetEntity: Attachment::class, mappedBy: 'track', cascade: ['persist'])]
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
    private ?string $Location = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?Region $region = null;

    #[ORM\Column(length: 2083, nullable: true)]
    private ?string $url = null;

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
        return $this->Location;
    }

    public function setLocation(?string $Location): static
    {
        $this->Location = $Location;

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

    public function getVideoPreview(): ?string
    {
        if (!$this->url) {
            return null;
        }

        $url_components = parse_url($this->url);
        parse_str($url_components['query'], $params);

        return 'https://img.youtube.com/vi/'. $params['v'] . '/hqdefault.jpg';
    }

    public function getVideoEmbed(): ?string
    {
        if (!$this->url) {
            return null;
        }

        $url_components = parse_url($this->url);
        parse_str($url_components['query'], $params);

        return 'https://www.youtube.com/embed/' . $params['v'];
    }

}
