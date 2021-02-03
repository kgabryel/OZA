<?php

namespace App\Form\ProductList;

use Symfony\Component\OptionsResolver\OptionsResolver;

class EditForm extends ListForm
{
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'multiple' => true,
                'compound' => true,
                'csrf_protection' => false
            ]
        );
    }

    public function getBlockPrefix()
    {
        return 'list_form';
    }
}
