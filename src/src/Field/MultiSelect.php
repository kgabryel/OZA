<?php

namespace App\Field;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class MultiSelect extends AbstractType
{
    public function getParent()
    {
        return ChoiceType::class;
    }
}