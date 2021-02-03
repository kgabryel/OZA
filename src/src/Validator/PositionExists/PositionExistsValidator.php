<?php

namespace App\Validator\PositionExists;

use App\Model\Product\Position;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class PositionExistsValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint)
    {
        /* @var $value Position */
        if ($value->getStuff() !== null || $value->getProduct() !== null) {
            return;
        }
        if ($value->getStuff() === null && $value->getProduct() === null) {
            $this->context->buildViolation('Nie wybrano pozycji.')
                ->addViolation();
            return;
        }
        if ($value->getProduct() !== null) {
            $this->context->buildViolation('Wybrano błędny towar.')
                ->addViolation();
        } else {
            $this->context->buildViolation('Wybrano błędny produkt.')
                ->addViolation();
        }
    }
}
