<?php

namespace App\Security\Voter;

use App\Entity\Interface\BlameableInterface;
use App\Entity\User;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

readonly class BlameableEntitySecurityChecker
{
    public function __construct(
        private Security $security,
        private AuthorizationCheckerInterface $authorizationChecker,
    )
    {
    }

    public function canView(BlameableInterface $entity): bool
    {
        $user = $this->security->getUser();
        if (!$user instanceof User) {
            return false;
        }

        if ($this->authorizationChecker->isGranted('ROLE_VALIDATED_USER')) {
            return true;
        }

        return !$entity->isDisabled() && $entity->isValidated();
    }

    public function canEdit(BlameableInterface $entity): bool
    {
        if (!$this->canView($entity)) {
            return false;
        }

        return $this->authorizationChecker->isGranted('ROLE_MODERATOR');
    }
}