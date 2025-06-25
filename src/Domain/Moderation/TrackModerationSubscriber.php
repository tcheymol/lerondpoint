<?php

namespace App\Domain\Moderation;

use App\Entity\Track;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsEntityListener;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Doctrine\ORM\Events;

#[AsEntityListener(event: Events::preUpdate, method: 'preUpdate', entity: Track::class)]
readonly class TrackModerationSubscriber
{
    public function __construct(private ModerationMailer $mailer)
    {
    }

    public function preUpdate(Track $track, PreUpdateEventArgs $event): void
    {
        $this->handleCreation($event, $track);
        $this->handleValidation($event, $track);
        $this->handleRejection($event, $track);
    }

    public function handleCreation(PreUpdateEventArgs $event, Track $track): void
    {
        if ($event->hasChangedField('isDraft') && !$track->isDraft()) {
            $this->mailer->create($track);
        }
    }

    public function handleValidation(PreUpdateEventArgs $event, Track $track): void
    {
        if ($event->hasChangedField('validated') && $track->isValidated()) {
            $this->mailer->validate($track);
        }
    }

    public function handleRejection(PreUpdateEventArgs $event, Track $track): void
    {
        if ($event->hasChangedField('rejected') && $track->isRejected()) {
            $this->mailer->reject($track);
        }
    }
}
