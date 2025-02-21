<?php

namespace App\EventSubscriber;

use App\Entity\Interface\BlameableInterface;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsDoctrineListener;
use Doctrine\ORM\Event\PrePersistEventArgs;
use Doctrine\ORM\Event\PreRemoveEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Doctrine\ORM\Events;
use Symfony\Bundle\SecurityBundle\Security;

#[AsDoctrineListener(event: Events::preUpdate, priority: 500, connection: 'default')]
#[AsDoctrineListener(event: Events::prePersist, priority: 500, connection: 'default')]
#[AsDoctrineListener(event: Events::preRemove, priority: 500, connection: 'default')]
readonly class DisableSubscriber
{
    public function __construct(private Security $security)
    {
    }

    public function preUpdate(PreUpdateEventArgs $args): void
    {
        $entity = $args->getObject();
        if (!$entity instanceof BlameableInterface) {
            return;
        }
        $entity->setUpdatedAt(new \DateTimeImmutable());

        $user = $this->security->getUser();
        if (!$user instanceof User) {
            return;
        }

        if ($args->hasChangedField('disabled') && true === $args->getNewValue('disabled')) {
            $entity->setDisabledBy($user);
        }
        if ($args->hasChangedField('validated') && true === $args->getNewValue('validated')) {
            $entity->setValidatedBy($user);
        }

        $entity->setUpdatedBy($user);
    }

    public function prePersist(PrePersistEventArgs $args): void
    {
        $entity = $args->getObject();
        if (!$entity instanceof BlameableInterface) {
            return;
        }
        $entity->setCreatedAt(new \DateTimeImmutable());
        $entity->setUpdatedAt(new \DateTimeImmutable());

        $user = $this->security->getUser();
        if ($user instanceof User) {
            $entity->setCreatedBy($user);
            $entity->setUpdatedBy($user);
        }
    }

    public function preRemove(PreRemoveEventArgs $args): void
    {
        $entity = $args->getObject();
        if (!$entity instanceof BlameableInterface) {
            return;
        }

        $entity->setDeletedAt(new \DateTimeImmutable());

        $user = $this->security->getUser();
        if ($user instanceof User) {
            $entity->setDeletedBy($user);
        }
    }
}
