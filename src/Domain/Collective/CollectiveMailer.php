<?php

namespace App\Domain\Collective;

use App\Entity\Collective;
use App\Entity\Invitation;
use App\Helper\AbstractMailer;
use App\Helper\EmailHelper;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Contracts\Translation\TranslatorInterface;

readonly class CollectiveMailer extends AbstractMailer
{
    public function __construct(private EmailHelper $emailHelper, private TranslatorInterface $translator)
    {
        parent::__construct($emailHelper);
    }

    public function sendCreationEmail(Collective $collective): void
    {
        $creatorEmail = $collective->getCreatedBy()?->getEmail();
        if ($creatorEmail) {
            $template = $this->createCreationEmail($collective);
            $this->sendEmail($template, $creatorEmail);
        }
    }

    public function sentInviteMail(Invitation $invitation): void
    {
        if (!$invitation->getUnregisteredEmail() || !$invitation->getCollective()) {
            return;
        }
        $template = $this->createInviteEmail($invitation->getCollective());
        $this->sendEmail($template, $invitation->getUnregisteredEmail());
    }

    private function createInviteEmail(Collective $collective): TemplatedEmail
    {
        return $this->emailHelper->createTemplatedEmail()
            ->subject($this->translator->trans('YouHaveBeenInvited'))
            ->htmlTemplate('collective/email/user_invited_email.html.twig')
            ->context(['collective' => $collective])
        ;
    }

    private function createCreationEmail(Collective $collective): TemplatedEmail
    {
        return $this->emailHelper->createTemplatedEmail()
            ->subject($this->translator->trans('YourGroupHasBeenCreated', ['%groupName%' => $collective->getName()]))
            ->htmlTemplate('collective/email/group_created_email.html.twig')
            ->context(['collective' => $collective])
        ;
    }
}
