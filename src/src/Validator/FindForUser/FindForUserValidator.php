<?php

namespace App\Validator\FindForUser;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class FindForUserValidator extends ConstraintValidator
{

    public function validate($value, Constraint $constraint)
    {
        /* @var FindForUser $constraint */

        if ($value === null) {
            return;
        }
        $repository = $constraint->getRepository();
        $entity = $repository->filterForUser(
            $constraint->getColumnName(),
            $constraint->getGetter()($value),
            $constraint->getUserColumn(),
            $constraint->getUser(),
            $constraint->getId(),
            $constraint->isNumeric()
        );
        if (($entity === []) === $constraint->isEmpty()) {
            return;
        }
        $this->context->buildViolation($constraint->message)
            ->setParameter('{{ value }}', $value)
            ->addViolation();
    }
}
