<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;

#[\Attribute(\Attribute::TARGET_CLASS)]
final class AttachmentOrUrl extends Constraint
{
    public string $message = 'Vous devez ajouter une photo ou un lien vidéo';

    public function __construct(
        public string $mode = 'strict',
        ?array $groups = null,
        mixed $payload = null,
    ) {
        parent::__construct([], $groups, $payload);
    }

    #[\Override]
    public function getTargets(): string
    {
        return self::CLASS_CONSTRAINT;
    }
}
