<?php

namespace App\Entity;

use App\Entity\Interface\BlameableInterface;
use App\Entity\Trait\BlameableTrait;
use App\Repository\ActionRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ActionRepository::class)]
class Action implements BlameableInterface
{
    use BlameableTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    public function __construct(#[ORM\Column(length: 255)]
        private ?string $name = null,
        #[ORM\Column(length: 255, nullable: true)]
        private ?string $iconPath = null,
    ) {
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

    public function getIconPath(): ?string
    {
        return $this->iconPath;
    }

    public function setIconPath(?string $iconPath): static
    {
        $this->iconPath = $iconPath;

        return $this;
    }

    public function getIconPublicPath(?bool $big = false): string
    {
        if (!$this->iconPath) {
            return '';
        }

        $folder = sprintf('/images/action/%s', $big ? 'big/' : '');

        return sprintf('%s%s.png', $folder, $this->iconPath);
    }
}
