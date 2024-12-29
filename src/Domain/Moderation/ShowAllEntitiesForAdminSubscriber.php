<?php

namespace App\Domain\Moderation;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

readonly class ShowAllEntitiesForAdminSubscriber implements EventSubscriberInterface
{
    public function __construct(
        private Security $security,
        private EntityManagerInterface $em
    )
    {
    }

    public function onRequest(): void
    {
        $filterManager = $this->em->getFilters();

        if (!$this->security->isGranted('ROLE_ADMIN')) {
            $filterManager->enable('validated_entity');
        }
    }

    public static function getSubscribedEvents(): array
    {
        return [
            'kernel.controller' => 'onRequest',
        ];
    }
}
