<?php

namespace App\Helper;

use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;

readonly class EmailHelper
{
    private const string FROM = 'contact@le-rondpoint.org';
    private const string FROM_NAME = 'Le Rond-point';

    public function __construct(private MailerInterface $mailer)
    {
    }

    public function createTemplatedEmail(): TemplatedEmail
    {
        return new TemplatedEmail()->from(new Address(self::FROM, self::FROM_NAME));
    }

    public function send(TemplatedEmail $email): void
    {
        try {
            $this->mailer->send($email);
        } catch (TransportExceptionInterface $e) {
            throw new \RuntimeException(sprintf('An error occurred while sending the email : %s', $e->getMessage()));
        }
    }
}
