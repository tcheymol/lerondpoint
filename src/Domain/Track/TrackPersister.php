<?php

namespace App\Domain\Track;

use App\Entity\Track;
use Doctrine\ORM\EntityManagerInterface;

readonly class TrackPersister
{
    public function __construct(
        private EntityManagerInterface $em,
        private TrackAttachmentHelper $attachmentHelper,
        private TrackVideoHelper $videoHelper,
    ) {
    }

    public function persist(Track $track): Track
    {
        $this->attachmentHelper->handleAttachments($track);
        $this->videoHelper->handleVideo($track);
        $this->em->persist($track);
        $this->em->flush();

        return $track;
    }

    public function publish(Track $track): void
    {
        $track->publish();
        $this->em->flush();
    }

    public function accept(Track $track): void
    {
        $track->accept();
        $this->em->flush();
    }

    public function reject(Track $track): void
    {
        $track->reject();
        $this->em->flush();
    }

    public function remove(Track $track): void
    {
        $this->em->remove($track);
        $this->em->flush();
    }
}
