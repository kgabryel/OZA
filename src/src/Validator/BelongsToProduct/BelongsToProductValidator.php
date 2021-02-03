<?php

namespace App\Validator\BelongsToProduct;

use App\Model\Product\Stuff;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class BelongsToProductValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint)
    {
        /* @var $constraint BelongsToProduct */
        $product = $constraint->getProduct();
        if ($product === null) {
            return;
        }
        $measures = array_keys(
            $constraint->getProduct()
                ->getMeasures()
        );
        if ($value === null || $value instanceof Stuff) {
            return;
        }
        if (in_array($value->getId(), $measures, true)) {
            return;
        }
        $this->context->buildViolation($constraint->message)
            ->addViolation();
    }
}
