<?php

namespace App\Domain\Newsletter;

use App\Entity\NewsletterRegistration;
use App\Repository\NewsletterRegistrationRepository;

readonly class NewsletterSubscriber
{
    public function __construct(private NewsletterRegistrationRepository $repository, private NewsletterMailer $mailer)
    {
    }

    public function subscribe(NewsletterRegistration $registration, bool $checkExisting = false): void
    {
        if (!$checkExisting) {
            $this->repository->persist($registration);
        } else {
            $this->repository->subscribeBack($registration);
        }

        $this->mailer->subscribe($registration->getEmail());
    }

    public function unsubscribe(NewsletterRegistration $registration): void
    {
        $this->repository->unsubscribe($registration);

        $this->mailer->unsubscribe($registration->getEmail());
    }
}
