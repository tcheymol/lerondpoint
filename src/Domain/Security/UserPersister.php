<?php

namespace App\Domain\Security;

use App\Entity\User;
use App\Helper\PasswordHelper;
use App\Security\EmailVerifier;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mime\Address;
use Symfony\Contracts\Translation\TranslatorInterface;

readonly class UserPersister
{
    public const string SENDER_EMAIL = 'contact@le-rondpoint.org';
    public const string SENDER_NAME = 'le rond-point';

    public function __construct(
        private PasswordHelper $helper,
        private EntityManagerInterface $em,
        private LoggerInterface $logger,
        private EmailVerifier $emailVerifier,
        private TranslatorInterface $translator,
    ) {
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
            $this->em->flush();

            $this->emailVerifier->sendEmailConfirmation('app_verify_email', $user,
                (new TemplatedEmail())
                    ->from(new Address(self::SENDER_EMAIL, self::SENDER_NAME))
                    ->to($userEmail)
                    ->subject($this->translator->trans('VerifyEmailSubject'))
                    ->htmlTemplate('security/confirmation_email.html.twig')
            );
        } catch (\Exception|TransportExceptionInterface $e) {
            $this->logger->error('An error occurred sending registration email : '.$e->getMessage());
        }
    }
}
