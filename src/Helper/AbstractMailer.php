<?php

namespace App\Helper;

use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mime\Address;

abstract readonly class AbstractMailer
{
    public function __construct(private EmailHelper $helper)
    {
    }

    protected function sendEmail(TemplatedEmail $email, ?string $recipient = null): void
    {
        if (!$recipient) {
            return;
        }

        $email->to(new Address($recipient));

        $this->helper->send($email);
    }
}
