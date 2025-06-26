<?php

namespace App\Domain\Track;

use App\Domain\Images\AttachmentHelper;
use App\Entity\Track;
use App\Repository\AttachmentRepository;
use Doctrine\ORM\EntityManagerInterface;

readonly class TrackAttachmentHelper
{
    public function __construct(
        private AttachmentHelper $attachmentHelper,
        private AttachmentRepository $repository,
    ) {
    }

    public function handleAttachments(Track $track): void
    {
        foreach ($track->attachmentsIds as $attachmentId) {
            $track->addAttachment($this->repository->find($attachmentId));
        }
    }

    public function deleteAttachments(Track $track): void
    {
        foreach ($track->getAttachments() as $attachment) {
            $this->attachmentHelper->delete($attachment);
        }
    }
}
