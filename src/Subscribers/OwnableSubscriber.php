<?php

namespace App\Subscribers;

use App\Entity\OwnableInterface;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsDoctrineListener;
use Doctrine\ORM\Event\PrePersistEventArgs;
use Doctrine\ORM\Events;
use Symfony\Bundle\SecurityBundle\Security;

#[AsDoctrineListener(event: Events::prePersist, priority: 500, connection: 'default')]
readonly class OwnableSubscriber
{
    public function __construct(private Security $security)
    {
    }

    public function prePersist(PrePersistEventArgs $args): void
    {
        $entity = $args->getObject();
        if (!$entity instanceof OwnableInterface) {
            return;
        }

        $entity->setOwner($this->security->getUser());
    }
}
