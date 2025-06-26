<?php

namespace App\Domain\Track;

use App\Domain\Security\SessionAwareTrait;
use App\Entity\RejectionCause;
use App\Entity\Track;
use App\Form\TrackType;
use App\Repository\AttachmentRepository;
use App\Repository\TrackRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

readonly class TrackPersister
{
    use SessionAwareTrait;

    public function __construct(
        private EntityManagerInterface $em,
        private TrackAttachmentHelper $attachmentHelper,
        private TrackVideoHelper $videoHelper,
        private RequestStack $requestStack,
        private TrackRepository $trackRepository,
        private AuthorizationCheckerInterface $authorizationChecker,
        private AttachmentRepository $attachmentRepository,
    ) {
    }

    public function persist(Track $track, ?int $creationStep = 1): Track
    {
        $isInSession = null === $track->getId();

        $track->bumpCreationStep($creationStep);
        $this->attachmentHelper->handleAttachments($track);
        $this->videoHelper->handleVideo($track);
        $this->em->persist($track);
        $this->em->flush();

        if ($isInSession) {
            $this->updateSessionTrack($track);
        }

        return $track;
    }

    public function publish(Track $track): void
    {
        $this->clearSessionTrack();
        $track->setCreationStep(TrackType::STEPS_COUNT + 1);
        $track->publish();
        $this->em->flush();
    }

    public function accept(Track $track): void
    {
        $track->accept();
        $this->em->flush();
    }

    public function reject(Track $track, ?RejectionCause $rejectionCause): void
    {
        $track->setRejectionCause($rejectionCause);
        $track->reject();
        $this->em->flush();
    }

    public function remove(Track $track): void
    {
        $this->em->remove($track);
        $this->em->flush();
    }

    public function fetchSessionTrack(): Track
    {
        $trackId = $this->getSession()->get('being-created-track-id');
        $track = !$trackId ? null : $this->trackRepository->find($trackId);

        if (
            $this->authorizationChecker->isGranted('ROLE_USER')
            && !$this->authorizationChecker->isGranted('EDIT', $track)
        ) {
            $track = null;
        }

        return !$track ? new Track() : $track;
    }

    public function updateSessionTrack(Track $track): void
    {
        $this->requestStack->getSession()->set('being-created-track-id', $track->getId());
    }

    public function markTrackFinished(Track $track): void
    {
        $track->setCreationStep(TrackType::STEPS_COUNT + 1);
        $this->em->flush();
    }

    private function clearSessionTrack(): void
    {
        $this->requestStack->getSession()->remove('being-created-track-id');
    }

    public function updateCover(Track $track, ?int $newCoverId): void
    {
        if (!$newCoverId) {
            return;
        }

        $cover = $this->attachmentRepository->find($newCoverId);
        if ($cover) {
            $track->setCoverAttachment($cover);
            $this->em->flush();
        }
    }
}
