<?php

namespace App\Domain\Security;

use App\Entity\User;
use App\Helper\PasswordHelper;
use Doctrine\ORM\EntityManagerInterface;

readonly class UserPersister
{
    public function __construct(
        private PasswordHelper $helper,
        private EntityManagerInterface $em,
    ) {
    }

    public function persist(User $user): void
    {
        $this->helper->updateUserPasswordWithPlain($user);
        $this->em->persist($user);
        $this->em->flush();
    }
}
