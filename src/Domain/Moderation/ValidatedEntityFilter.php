<?php

namespace App\Domain\Moderation;

use App\Entity\Track;
use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\ORM\Query\Filter\SQLFilter;

class ValidatedEntityFilter extends SQLFilter
{

    public function addFilterConstraint(ClassMetadata $targetEntity, string $targetTableAlias): string
    {
        if ($targetEntity->getReflectionClass()->name !== Track::class) {
            return '';
        }

        return sprintf('%s.validated = 1', $targetTableAlias);
    }
}