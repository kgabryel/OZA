<?php

namespace App\Validator\CorrectPosition;

use App\Model\Shopping;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class CorrectPositionValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint)
    {
        /* @var $constraint CorrectPosition */

        /* @var $value Shopping */
        if ($value->getProduct() === null && $value->getStuff() === null) {
            $this->context->buildViolation('Nie wybrano produktu.')
                ->addViolation();
        }
        $product = $value->getProduct();
        if ($value->getStuff() !== null) {
            $product = $value->getStuff()
                ->getProduct();
        }
        if ($product->getUser() === $constraint->getUser()) {
            return;
        }
        $this->context->buildViolation($constraint->message)
            ->addViolation();
    }
}
