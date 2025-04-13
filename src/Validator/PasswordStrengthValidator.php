<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use ZxcvbnPhp\Zxcvbn;

class PasswordStrengthValidator extends ConstraintValidator
{
    public function validate(mixed $value, Constraint $constraint): void
    {
        if (!$constraint instanceof PasswordStrength || !is_string($value)) {
            return;
        }

        $result = new Zxcvbn()->passwordStrength($value);
        $score = $result['score'];

        if ($score < $constraint->minScore) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ score }}', $score)
                ->addViolation();
        }
    }
}
