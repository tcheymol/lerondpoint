<?php

namespace App\Subscribers;

use App\Entity\Trait\BlameableTrait;
use App\Helper\TraitHelper;
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
        if (!TraitHelper::usesTrait($entity, BlameableTrait::class)) {
            return;
        }

        if ($args->hasChangedField('disabled') && true === $args->getNewValue('disabled')) {
            $entity->setDisabledBy($this->security->getUser());
        }
        if ($args->hasChangedField('validated') && true === $args->getNewValue('validated')) {
            $entity->setValidatedBy($this->security->getUser());
        }

        $entity->setUpdatedAt(new \DateTimeImmutable());
        $entity->setUpdatedBy($this->security->getUser());
    }

    public function prePersist(PrePersistEventArgs $args): void
    {
        $entity = $args->getObject();
        if (!TraitHelper::usesTrait($entity, BlameableTrait::class)) {
            return;
        }

        $entity->setCreatedAt(new \DateTimeImmutable());
        $entity->setCreatedBy($this->security->getUser());
        $entity->setUpdatedAt(new \DateTimeImmutable());
        $entity->setUpdatedBy($this->security->getUser());
    }

    public function preRemove(PreRemoveEventArgs $args): void
    {
        $entity = $args->getObject();
        if (!TraitHelper::usesTrait($entity, BlameableTrait::class)) {
            return;
        }

        $entity->setDeletedAt(new \DateTimeImmutable());
        $entity->setDeletedBy($this->security->getUser());
    }
}
