<?php

namespace App\Entity\Trait;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

trait DisableTrait
{
    #[ORM\Column(type: Types::BOOLEAN)]
    protected bool $disabled = false;

    public function isDisabled(): bool
    {
        return $this->disabled;
    }

    public function disable(): void
    {
        $this->disabled = true;
    }

    public function enable(): void
    {
        $this->disabled = false;
    }
}