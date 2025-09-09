<?php

namespace App\Domain\Newsletter;

use App\Entity\NewsletterRegistration;
use App\Repository\NewsletterRegistrationRepository;

readonly class NewsletterSubscriber
{
    public function __construct(private NewsletterRegistrationRepository $repository, private NewsletterMailer $mailer)
    {
    }

    public function subscribe(NewsletterRegistration $registration): void
    {
        $existingRegistration = $this->repository->findExisting($registration);
        if ($existingRegistration) {
            if ($existingRegistration->isUnsubscribed()) {
                $this->repository->subscribeBack($existingRegistration);
            }
        } else {
            $this->repository->persist($registration);
        }

        $this->mailer->subscribe($registration->getEmail());
    }

    public function unsubscribe(NewsletterRegistration $registration): void
    {
        $this->repository->unsubscribe($registration);

        $this->mailer->unsubscribe($registration->getEmail());
    }
}
