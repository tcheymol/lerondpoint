<?php

namespace App\Subscribers;

use App\Entity\Trait\DisableTrait;
use App\Helper\TraitHelper;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsDoctrineListener;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Doctrine\ORM\Events;
use Symfony\Bundle\SecurityBundle\Security;

#[AsDoctrineListener(event: Events::preUpdate, priority: 500, connection: 'default')]
readonly class DisableSubscriber
{
    public function __construct(private Security $security)
    {
    }

    public function preUpdate(PreUpdateEventArgs $args): void
    {
        $entity = $args->getObject();
        if (!TraitHelper::usesTrait($entity, DisableTrait::class)) {
            return;
        }

        if ($args->hasChangedField('disabled') && $args->getNewValue('disabled') === true) {
            $entity->setDisabledBy($this->security->getUser());
        }
    }
}