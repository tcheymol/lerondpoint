<?php

namespace App\Helper;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

readonly class PasswordHelper
{
    public function __construct(private EntityManagerInterface $em, private UserPasswordHasherInterface $hasher)
    {
    }

    public function hashUserPlainPassword(User $user): string
    {
        return $this->hasher->hashPassword($user, (string) $user->getPlainPassword());
    }

    public function updateUserPasswordWithPlain(User $user): void
    {
        if (null === $user->getPlainPassword()) {
            return;
        }
        $user->setPassword($this->hashUserPlainPassword($user));
        $this->em->persist($user);
        $this->em->flush();
    }
}
