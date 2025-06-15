<?php

namespace App\Validator;

use App\Entity\Track;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

final class AttachmentOrUrlValidator extends ConstraintValidator
{
    public function validate(mixed $value, Constraint $constraint): void
    {
        if (!$constraint instanceof AttachmentOrUrl) {
            throw new UnexpectedTypeException($constraint, AttachmentOrUrl::class);
        }
        if (null === $value || '' === $value) {
            return;
        }

        if (!$value instanceof Track) {
            return;
        }

        if ($value->url || $value->hasAttachments() || count($value->attachmentsIds) > 0) {
            return;
        }

        $this->context->buildViolation($constraint->message)
            ->addViolation()
        ;
    }
}
