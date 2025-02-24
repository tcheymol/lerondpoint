<?php

namespace App\Domain\Collective;

use App\Entity\Collective;
use App\Repository\CollectiveRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RequestStack;

readonly class CollectivePersister
{
    public function __construct(
        private EntityManagerInterface $em,
        private RequestStack $requestStack,
        private CollectiveRepository $collectiveRepository,
    ) {
    }

    public function fetchSessionCollective(): Collective
    {
        $collectiveId = $this->requestStack->getSession()->get('being-created-collective-id');
        $collective = !$collectiveId ? null : $this->collectiveRepository->find($collectiveId);

        return !$collective ? new Collective() : $collective;
    }

    public function updateSessionCollective(Collective $collective): void
    {
        $this->requestStack->getSession()->set('being-created-collective-id', $collective->getId());
    }

    public function clearSessionCollective(): void
    {
        $this->requestStack->getSession()->remove('being-created-collective-id');
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
}
