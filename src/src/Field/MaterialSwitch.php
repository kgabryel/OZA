<?php

namespace App\Field;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MaterialSwitch extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);
    }

    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['on'] = $options['on'];
        $view->vars['off'] = $options['off'];
    }

    public function getParent()
    {
        return CheckboxType::class;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'on' => 'Aktywne',
                'off' => 'Nieaktywne',
            ]
        );
        $resolver->setAllowedTypes('on', ['string']);
        $resolver->setAllowedTypes('off', ['string']);
    }
}