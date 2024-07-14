<?php

namespace App\Entity\Trait;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

trait ValidatedTrait
{
    #[ORM\Column(type: Types::BOOLEAN)]
    protected bool $validated = false;

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
}