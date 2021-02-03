<?php

namespace App\Validator\UniqueForSupply;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class UniqueForSupplyValidator extends ConstraintValidator
{

    public function validate($value, Constraint $constraint)
    {
        /* @var UniqueForSupply $constraint */

        if (null === $value) {
            return;
        }
        $repository = $constraint->getRepository();
        $entity = $repository->findBy(
            [
                'supply' => $constraint->getId(),
                $constraint->getColumn() => $value
            ]
        );
        if ($entity === []) {
            return;
        }
        $this->context->buildViolation($constraint->message)
            ->addViolation();
    }
}
