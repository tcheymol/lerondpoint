<?php

namespace App\Entity\Trait;

use App\Entity\User;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

trait DisableTrait
{
    #[ORM\Column(type: Types::BOOLEAN)]
    protected bool $disabled = false;

    #[ORM\ManyToOne]
    private ?User $disabledBy = null;

    public function isDisabled(): bool
    {
        return $this->disabled;
    }

    public function setDisabled(?bool $disabled = false): void
    {
        $this->disabled = $disabled;
    }

    public function disable(): void
    {
        $this->disabled = true;
    }

    public function enable(): void
    {
        $this->disabled = false;
    }

    public function getDisabledBy(): ?User
    {
        return $this->disabledBy;
    }

    public function setDisabledBy(?User $disabledBy): static
    {
        $this->disabledBy = $disabledBy;

        return $this;
    }
}