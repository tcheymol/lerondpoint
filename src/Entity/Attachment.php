<?php

namespace App\Entity;

use App\Entity\Trait\DisableTrait;
use App\Entity\Trait\ValidatedTrait;
use App\Repository\AttachmentRepository;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Blameable\Traits\Blameable;
use Gedmo\SoftDeleteable\Traits\SoftDeleteable;
use Gedmo\Timestampable\Traits\TimestampableEntity;

#[ORM\Entity(repositoryClass: AttachmentRepository::class)]
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
    private ?string $path = null;

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

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPath(): ?string
    {
        return $this->path;
    }

    public function setPath(string $path): static
    {
        $this->path = $path;

        return $this;
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
}
