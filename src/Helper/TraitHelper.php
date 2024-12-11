<?php

namespace App\Helper;

class TraitHelper
{
    public static function usesTrait(?object $entity, string $traitFqcn): bool
    {
        if (!$entity) {
            return false;
        }

        return class_uses($entity) && in_array($traitFqcn, class_uses($entity));
    }
}
