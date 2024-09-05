<?php

namespace App\Entity;

use AllowDynamicProperties;
use App\Entity\Trait\DisableTrait;
use App\Entity\Trait\ValidatedTrait;
use App\Repository\AttachmentRepository;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Blameable\Traits\Blameable;
use Gedmo\SoftDeleteable\Traits\SoftDeleteable;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Uid\Uuid;

#[AllowDynamicProperties] #[ORM\Entity(repositoryClass: AttachmentRepository::class)]
class Attachment
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
    private ?string $extension = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $kind = null;

    #[ORM\Column]
    private ?int $size = null;

    #[ORM\ManyToOne(inversedBy: 'attachments')]
    private ?Action $action = null;

    #[ORM\ManyToOne(inversedBy: 'attachments')]
    private ?Track $track = null;

    #[ORM\Column(type: 'uuid', nullable: true)]
    private ?Uuid $objectId = null;

    public ?string $url = null;

    public static function fromFile(UploadedFile $file): static
    {
        return (new static())
            ->setExtension($file->getExtension())
            ->setKind($file->guessExtension())
            ->setSize($file->getSize());
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

    public function getSize(): ?int
    {
        return $this->size;
    }

    public function setSize(int $size): static
    {
        $this->size = $size;

        return $this;
    }

    public function getAction(): ?Action
    {
        return $this->action;
    }

    public function setAction(?Action $action): static
    {
        $this->action = $action;

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

    public function getObjectId(): ?Uuid
    {
        return $this->objectId;
    }

    public function setObjectId(?Uuid $objectId): static
    {
        $this->objectId = $objectId;

        return $this;
    }
}
