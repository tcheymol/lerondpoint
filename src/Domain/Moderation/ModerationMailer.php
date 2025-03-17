<?php

namespace App\Domain\Moderation;

use App\Entity\Track;
use App\Helper\AbstractMailer;
use App\Helper\EmailHelper;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Contracts\Translation\TranslatorInterface;

readonly class ModerationMailer extends AbstractMailer
{
    public function __construct(private EmailHelper $emailHelper, private TranslatorInterface $translator)
    {
        parent::__construct($emailHelper);
    }

    public function validate(Track $track): void
    {
        $email = $this->createValidationEmail($track);
        $this->sendEmail($email, $track->getCreatedBy()?->getEmail());
    }

    public function reject(Track $track): void
    {
        $email = $this->createRejectionEmail($track);
        $this->sendEmail($email, $track->getCreatedBy()?->getEmail());
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
}
