<?php

namespace App\Domain\Security;

use App\Entity\User;
use Symfony\Bundle\SecurityBundle\Security;

trait UserAwareTrait
{
    private readonly Security $security;

    public function getUser(): ?User
    {
        $user = $this->security->getUser();
        if (!$user instanceof User) {
            return null;
        }

        return $user;
    }
}
