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
}
