<?php

namespace App\Validator\CorrectMeasure;

use App\Model\Shopping;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class CorrectMeasureValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint)
    {

        /* @var $constraint CorrectMeasure */
        /* @var $value Shopping */
        if ($value->getMeasure() === null) {
            return;
        }
        if ($value->getMeasure() === null && $value->getProduct() === null) {
            return;
        }
        $product = $value->getProduct();
        if ($value->getStuff() !== null) {
            $product = $value->getStuff()
                ->getProduct();
        }
        $measure = $value->getMeasure();
        if ($measure->getMain() !== null) {
            $measure = $measure->getMain();
        }
        $productMeasure = $product->getMeasure();
        if ($productMeasure->getMain() !== null) {
            $productMeasure = $productMeasure->getMain();
        }
        if ($productMeasure === $measure) {
            return;
        }
        $this->context->buildViolation($constraint->message)
            ->addViolation();
    }
}
