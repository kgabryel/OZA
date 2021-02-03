<?php

namespace App\Validator\CorrectMeasure;

use Symfony\Component\Validator\Constraint;

class CorrectMeasure extends Constraint
{

    public string $message;

    public function __construct($options = null)
    {
        $this->message = 'Wybrana jednostka jest błędna';
        parent::__construct($options);
    }
}
