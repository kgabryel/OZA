<?php

namespace App\Field;

use Symfony\Component\Console\Exception\InvalidOptionException;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MaterialSelect extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        if (!isset($options['transformer']) || $options['transformer'] === null || !$options['transformer'] instanceof DataTransformerInterface) {
            throw new InvalidOptionException(
                sprintf(
                    'Option "transformer" must implement interface %s for constraint %s',
                    DataTransformerInterface::class,
                    __CLASS__
                )
            );
        }
        $builder->addModelTransformer($options['transformer']);
        parent::buildForm($builder, $options);
    }

    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['items'] = $options['items'];
        $view->vars['default'] = $options['default'];
        $view->vars['enabled'] = $options['enabled'];
    }

    public function getParent()
    {
        return HiddenType::class;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'items' => [],
                'transformer' => null,
                'default' => 0,
                'enabled' => true
            ]
        );
        $resolver->setAllowedTypes('default', ['int']);
        $resolver->setAllowedTypes('items', ['array']);
        $resolver->setAllowedTypes('enabled', ['bool']);
    }
}