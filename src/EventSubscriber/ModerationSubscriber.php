<?php

namespace App\EventSubscriber;

use App\Entity\Interface\BlameableInterface;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsDoctrineListener;
use Doctrine\ORM\Event\PrePersistEventArgs;
use Doctrine\ORM\Events;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

#[AsDoctrineListener(event: Events::prePersist, priority: 500, connection: 'default')]
readonly class ModerationSubscriber
{
    public function __construct(private AuthorizationCheckerInterface $authorizationChecker)
    {
    }

    public function prePersist(PrePersistEventArgs $args): void
    {
        $entity = $args->getObject();
        if (!$entity instanceof BlameableInterface) {
            return;
        }

        if ($this->authorizationChecker->isGranted('ROLE_VALIDATED_USER')) {
            $entity->accept();
        }
    }
}
