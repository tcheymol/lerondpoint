<?php

namespace App\Subscribers;

use App\Domain\Track\TrackAttachmentHelper;
use App\Entity\Track;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsEntityListener;
use Doctrine\ORM\Events;

#[AsEntityListener(event: Events::postRemove, method: 'postRemove', entity: Track::class)]
readonly class RemoveTrackSubscriber
{
    public function __construct(private TrackAttachmentHelper $helper)
    {
    }

    public function postRemove(Track $track): void
    {
        $this->helper->deleteAttachments($track);
    }
}