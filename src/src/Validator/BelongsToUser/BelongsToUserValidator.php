<?php

namespace App\Validator\BelongsToUser;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class BelongsToUserValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint)
    {
        if ($value === null) {
            return;
        }
        /* @var $constraint BelongsToUser */
        if ($value->getUser() === $constraint->getUser()) {
            return;
        }
        $this->context->buildViolation($constraint->message)
            ->addViolation();
    }
}
