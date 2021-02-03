<?php

namespace App\Form\ProductList;

use App\Field\ListPosition;
use App\Messages\ProductsListErrors;
use App\Validator\PositionExists\PositionExists;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Type;

class ListForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add(
            'name',
            null,
            [
                'label' => 'Nazwa',
                'constraints' => [
                    new Type(
                        [
                            'type' => 'string',
                            'message' => ProductsListErrors::getError(
                                ProductsListErrors::INVALID_VALUE
                            )
                        ]
                    ),
                    new Length(
                        [
                            'max' => 50,
                            'maxMessage' => ProductsListErrors::getError(
                                ProductsListErrors::NAME_TOO_LONG
                            )
                        ]
                    ),
                ]
            ]
        )
            ->add(
                'positions',
                CollectionType::class,
                [
                    'entry_type' => ListPosition::class,
                    'allow_add' => true,
                    'allow_extra_fields' => true,
                    'entry_options' => [
                        'error_bubbling' => false,
                        'constraints' => [
                            new PositionExists()
                        ]
                    ]
                ],
            );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'multiple' => true,
                'compound' => true,
            ]
        );
    }
}
