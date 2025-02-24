<?php

namespace App\Domain\Moderation;

use App\Entity\Track;
use App\Helper\EmailHelper;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mime\Address;
use Symfony\Contracts\Translation\TranslatorInterface;

readonly class ModerationMailer
{
    public function __construct(private EmailHelper $emailHelper, private TranslatorInterface $translator)
    {
    }

    public function validate(Track $track): void
    {
        $this->sendEmail($this->createValidationEmail($track), $track);
    }

    public function reject(Track $track): void
    {
        $this->sendEmail($this->createRejectionEmail($track), $track);
    }

    private function createValidationEmail(Track $track): TemplatedEmail
    {
        return $this->emailHelper->createTemplatedEmail()
            ->subject($this->translator->trans('TrackAcceptedEmailSubject'))
            ->htmlTemplate('moderation/track_accepted.html.twig')
            ->context(['track' => $track])
        ;
    }

    private function createRejectionEmail(Track $track): TemplatedEmail
    {
        return $this->emailHelper->createTemplatedEmail()
            ->subject($this->translator->trans('TrackRejectedEmailSubject'))
            ->htmlTemplate('moderation/track_rejected.html.twig')
            ->context(['track' => $track])
        ;
    }

    private function sendEmail(TemplatedEmail $email, Track $track): void
    {
        $recipient = $track->getCreatedBy()?->getEmail() ?? null;
        if (!$recipient) {
            return;
        }

        $email->to(new Address($recipient));

        $this->emailHelper->send($email);
    }
}
