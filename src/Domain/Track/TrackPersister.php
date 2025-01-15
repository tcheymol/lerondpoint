<?php

namespace App\Domain\Track;

use App\Entity\Track;
use Doctrine\ORM\EntityManagerInterface;

readonly class TrackPersister
{
    public function __construct(private EntityManagerInterface $em, private TrackAttachmentHelper $attachmentHelper)
    {
    }

    public function persist(Track $track): Track
    {
        $this->attachmentHelper->handleAttachments($track);
        $this->em->persist($track);
        $this->em->flush();

        return $track;
    }

    public function publish(Track $track): void
    {
        $track->publish();
        $this->em->flush();
    }

    public function remove(Track $track): void
    {
        $this->em->remove($track);
        $this->em->flush();
    }
}
