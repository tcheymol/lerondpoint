<?php

namespace App\Entity\Trait;

use App\Entity\User;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

trait ValidatedTrait
{
    #[ORM\Column(type: Types::BOOLEAN)]
    protected bool $validated = false;

    #[ORM\ManyToOne]
    private ?User $validatedBy = null;

    public function isValidated(): bool
    {
        return $this->validated;
    }

    public function validate(): void
    {
        $this->validated = true;
    }

    public function invalidate(): void
    {
        $this->validated = false;
    }

    public function getValidatedBy(): ?User
    {
        return $this->validatedBy;
    }

    public function setValidatedBy(?User $validatedBy): static
    {
        $this->validatedBy = $validatedBy;

        return $this;
    }
}