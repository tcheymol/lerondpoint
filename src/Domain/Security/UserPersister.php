<?php

namespace App\Domain\Security;

use App\Entity\User;
use App\Helper\PasswordHelper;
use App\Security\EmailVerifier;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Security\Core\User\UserInterface;

readonly class UserPersister
{
    public function __construct(
        private PasswordHelper $helper,
        private EntityManagerInterface $em,
        private LoggerInterface $logger,
        private EmailVerifier $emailVerifier,
    ) {
    }

    public function update(User $user): void
    {
        $this->helper->updateUserPasswordWithPlain($user);
        $this->em->flush();
    }

    public function persist(User $user): void
    {
        try {
            $userEmail = $user->getEmail();
            if (!$userEmail) {
                return;
            }
            $this->helper->updateUserPasswordWithPlain($user);
            $this->em->persist($user);
            $this->emailVerifier->sendEmailConfirmation($user);

            $this->update($user);
        } catch (\Exception|TransportExceptionInterface $e) {
            $this->logger->error('An error occurred sending registration email : '.$e->getMessage());
        }
    }

    public function acceptTerms(?UserInterface $user): void
    {
        if (!$user instanceof User) {
            return;
        }

        $user->acceptTerms();
        $this->em->flush();
    }
}
