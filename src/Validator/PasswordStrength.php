<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;

#[\Attribute]
class PasswordStrength extends Constraint
{
    public string $message = 'Votre mot de passe est trop faible (score: {{ score }}).';
    public int $minScore = \Symfony\Component\Validator\Constraints\PasswordStrength::STRENGTH_STRONG;

    public function __construct(?string $message = null, ?int $minScore = null, ?array $groups = null, $payload = null)
    {
        parent::__construct([], $groups, $payload);

        if ($minScore) {
            $this->minScore = $minScore;
        }
        if ($message) {
            $this->message = $message;
        }

        $this->message = $message ?? $this->message;
    }
}
