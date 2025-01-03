<?php

namespace App\Domain\Moderation;

use App\Entity\Track;
use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\ORM\Query\Filter\SQLFilter;

class ValidatedEntityFilter extends SQLFilter
{
    #[\Override]
    public function addFilterConstraint(ClassMetadata $targetEntity, string $targetTableAlias): string
    {
        $reflectionClass = $targetEntity->getReflectionClass();
        if ($reflectionClass && Track::class !== $reflectionClass->name) {
            return '';
        }

        return sprintf('%s.validated = 1', $targetTableAlias);
    }
}