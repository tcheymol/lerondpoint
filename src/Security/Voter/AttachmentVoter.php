<?php

namespace App\Security\Voter;

use App\Entity\Attachment;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Vote;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

/** @extends Voter<string, mixed> */
final class AttachmentVoter extends Voter
{
    public function __construct(private AuthorizationCheckerInterface $authorizationChecker) {
    }

    #[\Override]
    protected function supports(string $attribute, mixed $subject): bool
    {
        return in_array($attribute, [Constants::EDIT, Constants::VIEW])
            && $subject instanceof Attachment;
    }

    #[\Override]
    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token, ?Vote $vote = null): bool
    {
        return $this->authorizationChecker->isGranted($attribute, $subject->getTrack());
    }
}
