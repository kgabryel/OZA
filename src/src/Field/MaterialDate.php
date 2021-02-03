<?php

namespace App\Field;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class MaterialDate extends AbstractType
{
    public function getParent()
    {
        return TextType::class;
    }
}