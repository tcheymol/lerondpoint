<?php

namespace App\Security;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Contracts\Translation\TranslatorInterface;
use SymfonyCasts\Bundle\VerifyEmail\VerifyEmailHelperInterface;

readonly class EmailVerifier
{
    public const string SENDER_EMAIL = 'contact@le-rondpoint.org';
    public const string SENDER_NAME = 'le rond-point';

    public function __construct(
        private VerifyEmailHelperInterface $verifyEmailHelper,
        private MailerInterface $mailer,
        private EntityManagerInterface $em,
        private TranslatorInterface $translator,
    ) {
    }

    /** @throws TransportExceptionInterface */
    public function sendEmailConfirmation(User $user): void
    {
        $userId = (string) $user->getId();
        $userEmail = $user->getEmail();
        if (!$userId || !$userEmail) {
            return;
        }
        $email = (new TemplatedEmail())
            ->from(new Address(self::SENDER_EMAIL, self::SENDER_NAME))
            ->to($userEmail)
            ->subject($this->translator->trans('VerifyEmailSubject'))
            ->htmlTemplate('security/confirmation_email.html.twig');

        $signatureComponents = $this->verifyEmailHelper->generateSignature(
            'app_verify_email',
            $userId,
            $userEmail,
            ['id' => $userId],
        );

        $context = $email->getContext();
        $context['signedUrl'] = $signatureComponents->getSignedUrl();
        $context['expiresAtMessageKey'] = $signatureComponents->getExpirationMessageKey();
        $context['expiresAtMessageData'] = $signatureComponents->getExpirationMessageData();

        $email->context($context);

        $this->mailer->send($email);
    }

    public function handleEmailConfirmation(Request $request, User $user): void
    {
        $userId = (string) $user->getId();
        $userEmail = $user->getEmail();
        if (!$userId || !$userEmail) {
            return;
        }
        $this->verifyEmailHelper->validateEmailConfirmationFromRequest($request, $userId, $userEmail);

        $user->validateEmail();
        $this->em->flush();
    }
}
