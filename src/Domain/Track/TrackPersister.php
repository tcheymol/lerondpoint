<?php

namespace App\Domain\Track;

use App\Domain\Security\SessionAwareTrait;
use App\Entity\RejectionCause;
use App\Entity\Track;
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
    ) {
    }

    public function persist(Track $track): Track
    {
        $isInSession = null === $track->getId();

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

        if (!$this->authorizationChecker->isGranted('EDIT', $track)) {
            $track = null;
        }

        return !$track ? new Track() : $track;
    }
    private function updateSessionTrack(Track $track): void
    {
        $this->requestStack->getSession()->set('being-created-track-id', $track->getId());
    }

    private function clearSessionTrack(): void
    {
        $this->requestStack->getSession()->remove('being-created-track-id');
    }

}
