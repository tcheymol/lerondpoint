<?php

namespace App\Domain\Track;

use App\Domain\Images\AttachmentHelper;
use App\Entity\Track;
use App\Repository\AttachmentRepository;
use Psr\Log\LoggerInterface;

readonly class TrackAttachmentHelper
{
    public function __construct(
        private AttachmentHelper $attachmentHelper,
        private AttachmentRepository $repository,
        private LoggerInterface $logger,
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
            $track->removeAttachment($attachment);
            $this->attachmentHelper->delete($attachment);
        }
    }

    public function uploadMissingThumbnails(Track $track): void
    {
        foreach ($track->getAttachments() as $attachment) {
            try {
                $this->attachmentHelper->uploadMissingThumbnails($attachment);
            } catch (\Exception $e) {
                $this->logger->error(sprintf('Failure uploading thumbnail for track %d : %s', $track->getId(), $e->getMessage()));
            }
        }
    }
}
