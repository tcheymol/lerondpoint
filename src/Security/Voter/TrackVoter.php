<?php

namespace App\Security\Voter;

use App\Entity\Track;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

final class TrackVoter extends Voter
{

    public function __construct(
        private BlameableEntitySecurityChecker $blameableEntitySecurityChecker,
    )
    {
    }

    protected function supports(string $attribute, mixed $subject): bool
    {
        return in_array($attribute, [Constants::EDIT, Constants::VIEW])
            && $subject instanceof Track;
    }

    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();
        if (!$user instanceof UserInterface) {
            return false;
        }

        return match ($attribute) {
            Constants::EDIT => $this->blameableEntitySecurityChecker->canEdit(),
            Constants::VIEW => $this->blameableEntitySecurityChecker->canView(),
            default => false,
        };
    }
}
