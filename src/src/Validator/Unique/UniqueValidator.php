<?php

namespace App\Validator\Unique;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class UniqueValidator extends ConstraintValidator
{

    public function validate($value, Constraint $constraint)
    {
        /* @var $constraint Unique */

        if (null === $value) {
            return;
        }

        $user=$constraint->getRepository()->findOneBy([$constraint->getColumn()=>$value]);
        if($user===null){
            return;
        }
        $this->context->buildViolation($constraint->message)
            ->addViolation();
    }
}
