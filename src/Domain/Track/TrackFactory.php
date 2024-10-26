<?php

namespace App\Domain\Track;

use App\Domain\Security\UserAwareTrait;
use App\Entity\Track;
use Symfony\Bundle\SecurityBundle\Security;

class TrackFactory
{
    use UserAwareTrait;

    public function __construct(private readonly Security $security) {
    }

    public function create(): Track
    {
        $track = new Track();

        $user = $this->getUser();
        if ($user && !$user->hasMultipleCollectives()) {
            $track->setCollective($user->getFirstCollective());
        }

        return $track;
    }
}
