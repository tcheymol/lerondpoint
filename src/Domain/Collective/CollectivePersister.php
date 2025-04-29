<?php

namespace App\Domain\Collective;

use App\Domain\Security\SessionAwareTrait;
use App\Domain\Security\UserAwareTrait;
use App\Entity\Collective;
use App\Entity\Invitation;
use App\Repository\CollectiveRepository;
use App\Repository\InvitationRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\RequestStack;

readonly class CollectivePersister
{
    use UserAwareTrait;
    use SessionAwareTrait;

    public function __construct(
        private EntityManagerInterface $em,
        private RequestStack $requestStack,
        private CollectiveRepository $collectiveRepository,
        private UserRepository $userRepository,
        private InvitationRepository $invitationRepository,
        private Security $security,
        private CollectiveMailer $mailer,
    ) {
    }

    public function fetchSessionCollective(): Collective
    {
        $collectiveId = $this->getSession()->get('being-created-collective-id');
        $collective = !$collectiveId ? null : $this->collectiveRepository->find($collectiveId);

        return !$collective ? new Collective() : $collective;
    }

    private function updateSessionCollective(Collective $collective): void
    {
        $this->requestStack->getSession()->set('being-created-collective-id', $collective->getId());
    }

    private function clearSessionCollective(): void
    {
        $this->requestStack->getSession()->remove('being-created-collective-id');
    }

    public function inviteUser(Collective $collective, string $email): void
    {
        $user = $this->userRepository->findOneBy(['email' => $email]);

        $invitation = new Invitation($collective, $user, $this->getUser());
        if (!$user) {
            $invitation->setUnregisteredEmail($email);
        }

        if ($this->invitationRepository->findExistingInvitation($invitation)) {
            $this->addFlash('success', 'UserAlreadyInvited');

            return;
        }

        if ($invitation->isUnregistered()) {
            $this->mailer->sentInviteMail($invitation);
        } elseif ($user?->getCollectives()->contains($collective)) {
            $this->addFlash('success', 'UserAlreadyInCollective');

            return;
        }

        $this->em->persist($invitation);
        $this->em->flush();
        $this->addFlash('success', 'UserInvited');
    }

    public function persist(Collective $collective, bool $finishCreation): void
    {
        $isInSession = null === $collective->getId();

        $this->em->persist($collective);
        $this->em->flush();

        if ($isInSession) {
            $this->updateSessionCollective($collective);
        } elseif ($finishCreation) {
            $this->finishCreation($collective);
        }
    }

    private function finishCreation(Collective $collective): void
    {
        $this->clearSessionCollective();
        $collective->finishCreation();
        $this->em->flush();
    }

    public function acceptInvitation(Invitation $invitation): void
    {
        if ($invitation->getUser() && $invitation->getCollective()) {
            $invitation->getUser()->addCollective($invitation->getCollective());
        }

        $this->em->remove($invitation);
        $this->em->flush();
    }

    public function rejectInvitation(Invitation $invitation): void
    {
        $this->em->remove($invitation);
        $this->em->flush();
    }
}
