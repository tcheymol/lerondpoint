<?php

namespace App\Entity;

use App\Domain\Images\ThumbSize;
use App\Entity\Interface\BlameableInterface;
use App\Entity\Trait\BlameableTrait;
use App\Repository\AttachmentRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;

#[ORM\Entity(repositoryClass: AttachmentRepository::class)]
class Attachment implements BlameableInterface
{
    use BlameableTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $extension = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $kind = null;

    #[ORM\Column]
    private ?int $size = null;

    #[ORM\ManyToOne(inversedBy: 'attachments')]
    private ?Track $track = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $objectId = null;

    public ?string $objectUrl = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $thumbnailObjectId = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $mediumThumbnailObjectId = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $bigThumbnailObjectId = null;

    public ?string $smallThumbnailUrl = null;

    public ?string $mediumThumbnailUrl = null;

    public ?string $bigThumbnailUrl = null;

    #[ORM\Column(type: Types::BIGINT, nullable: true)]
    private ?string $height = null;

    #[ORM\Column(type: Types::BIGINT, nullable: true)]
    private ?string $width = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $url = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $previewUrl = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $videoEmbed = null;

    public static function fromFile(UploadedFile $file): self
    {
        return new Attachment()
            ->setExtension((string) $file->guessExtension())
            ->setKind($file->getMimeType())
            ->setSize($file->getSize());
    }

    public static function fromVideoData(string $url, string $previewUrl, string $videoEmbed): self
    {
        return new Attachment()
            ->setUrl($url)
            ->setExtension('mp4')
            ->setKind('video')
            ->setSize(0)
            ->setPreviewUrl($previewUrl)
            ->setVideoEmbed($videoEmbed);
    }

    /** @return string[] */
    public function getObjectIds(): array
    {
        return array_filter([
            $this->objectId,
            $this->thumbnailObjectId,
            $this->mediumThumbnailObjectId,
            $this->bigThumbnailObjectId,
        ], fn (?string $objectId) => null !== $objectId);
    }

    public function getImageObjectId(?ThumbSize $size = ThumbSize::Small): ?string
    {
        return match ($size) {
            ThumbSize::Medium => $this->mediumThumbnailObjectId,
            ThumbSize::Big => $this->bigThumbnailObjectId,
            ThumbSize::Full => $this->objectId,
            default => $this->thumbnailObjectId,
        };
    }

    /** @return array<string, ?string> */
    private function getImageUrls(): array
    {
        return [
            ThumbSize::Small->value => $this->smallThumbnailUrl,
            ThumbSize::Medium->value => $this->mediumThumbnailUrl,
            ThumbSize::Big->value => $this->bigThumbnailUrl,
            ThumbSize::Full->value => $this->objectUrl,
        ];
    }

    public function getImageUrl(ThumbSize $size = ThumbSize::Small): ?string
    {
        if ($this->getPreviewUrl()) {
            return $this->getVideoPreviewUrl($size);
        }

        return match ($size) {
            ThumbSize::Medium => $this->mediumThumbnailUrl,
            ThumbSize::Big => $this->bigThumbnailUrl,
            ThumbSize::Full => $this->objectUrl,
            default => $this->smallThumbnailUrl,
        };
    }

    private function getVideoPreviewUrl(ThumbSize $size): ?string
    {
        return match ($size) {
            ThumbSize::Full => $this->url,
            default => $this->previewUrl,
        };
    }

    public function getBestFitUrl(?ThumbSize $size = ThumbSize::Small): ?string
    {
        if ($size) {
            $exactSizeUrl = $this->getImageUrl($size);
            if (null === $exactSizeUrl) {
                return $this->getBestFitUrl();
            }
        }

        return array_find($this->getImageUrls(), fn ($url) => null !== $url);
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getExtension(): ?string
    {
        return $this->extension;
    }

    public function setExtension(string $extension): static
    {
        $this->extension = $extension;

        return $this;
    }

    public function getKind(): ?string
    {
        return $this->kind;
    }

    public function setKind(?string $kind): static
    {
        $this->kind = $kind;

        return $this;
    }

    public function isPdf(): bool
    {
        return 'application/pdf' === $this->getKind();
    }

    public function isVideo(): bool
    {
        return null !== $this->videoEmbed;
    }

    public function getSize(): ?int
    {
        return $this->size;
    }

    public function setSize(int $size): static
    {
        $this->size = $size;

        return $this;
    }

    public function getTrack(): ?Track
    {
        return $this->track;
    }

    public function setTrack(?Track $track): static
    {
        $this->track = $track;

        return $this;
    }

    public function isCover(): bool
    {
        return $this->track?->countAttachments() > 1 && $this === $this->track?->getCover();
    }

    public function getObjectId(): ?string
    {
        return $this->objectId;
    }

    public function setObjectId(?string $objectId): static
    {
        $this->objectId = $objectId;

        return $this;
    }

    public function getThumbnailObjectId(): ?string
    {
        return $this->thumbnailObjectId;
    }

    public function setThumbnailObjectId(?string $thumbnailObjectId): static
    {
        $this->thumbnailObjectId = $thumbnailObjectId;

        return $this;
    }

    public function getHeight(): ?string
    {
        return $this->height;
    }

    public function setHeight(?string $height): static
    {
        $this->height = $height;

        return $this;
    }

    public function getWidth(): ?string
    {
        return $this->width;
    }

    public function setWidth(?string $width): static
    {
        $this->width = $width;

        return $this;
    }

    public function getBigThumbnailObjectId(): ?string
    {
        return $this->bigThumbnailObjectId;
    }

    public function setBigThumbnailObjectId(?string $bigThumbnailObjectId): static
    {
        $this->bigThumbnailObjectId = $bigThumbnailObjectId;

        return $this;
    }

    public function getMediumThumbnailObjectId(): ?string
    {
        return $this->mediumThumbnailObjectId;
    }

    public function setMediumThumbnailObjectId(?string $mediumThumbnailObjectId): static
    {
        $this->mediumThumbnailObjectId = $mediumThumbnailObjectId;

        return $this;
    }

    public function hasMissingThumbnail(): bool
    {
        return !$this->thumbnailObjectId || !$this->mediumThumbnailObjectId || !$this->bigThumbnailObjectId;
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

    public function getPreviewUrl(): ?string
    {
        return $this->previewUrl;
    }

    public function setPreviewUrl(?string $previewUrl): static
    {
        $this->previewUrl = $previewUrl;

        return $this;
    }

    public function getVideoEmbed(): ?string
    {
        return $this->videoEmbed;
    }

    public function setVideoEmbed(?string $videoEmbed): static
    {
        $this->videoEmbed = $videoEmbed;

        return $this;
    }
}
