<?php

namespace App\Domain\Newsletter;

use App\Helper\AbstractMailer;
use App\Helper\EmailHelper;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Contracts\Translation\TranslatorInterface;

readonly class NewsletterMailer extends AbstractMailer
{
    public function __construct(private EmailHelper $emailHelper, private TranslatorInterface $translator)
    {
        parent::__construct($emailHelper);
    }

    public function subscribe(?string $email): void
    {
        $this->sendEmail($this->createSubscribedEmail(), $email);
    }

    public function unsubscribe(?string $email): void
    {
        $this->sendEmail($this->createUnsubscribedEmail(), $email);
    }

    private function createSubscribedEmail(): TemplatedEmail
    {
        return $this->emailHelper->createTemplatedEmail()
            ->subject($this->translator->trans('SuccessfullySubscribedToNewsletter'))
            ->htmlTemplate('newsletter/subscribe_success_email.html.twig')
        ;
    }

    private function createUnsubscribedEmail(): TemplatedEmail
    {
        return $this->emailHelper->createTemplatedEmail()
            ->subject($this->translator->trans('SuccessfullyUnsubscribedFromNewsletter'))
            ->htmlTemplate('newsletter/unsubscribe_success_email.html.twig')
        ;
    }
}
