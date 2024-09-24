<?php

namespace App\Domain\Track;

use App\Entity\Track;
use App\Helper\AttachmentHelper;
use Doctrine\ORM\EntityManagerInterface;

readonly class TrackPersister
{
    public function __construct(private EntityManagerInterface $em, private AttachmentHelper $attachmentHelper) {

    }

    public function persist(Track $track): Track {
        $this->attachmentHelper->handleAttachment($track);
        $this->em->persist($track);
        $this->em->flush();

        return $track;
    }
}