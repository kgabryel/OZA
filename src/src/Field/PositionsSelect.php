<?php

namespace App\Field;

use App\Transformer\PositionTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;

class PositionsSelect extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->addModelTransformer(new PositionTransformer());
        parent::buildForm($builder, $options);
    }

    public function getParent()
    {
        return CollectionType::class;
    }
}