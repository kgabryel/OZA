<?php

namespace App\Form;

use App\Field\PositionsSelect;
use App\Messages\QuickListErrors;
use App\Model\QuickListModel;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Type;

class QuickListForm extends AbstractType
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
                            'message' => QuickListErrors::getError(QuickListErrors::INVALID_VALUE)
                        ]
                    ),
                    new Length(
                        [
                            'max' => 50,
                            'maxMessage' => QuickListErrors::getError(QuickListErrors::INVALID_NAME)
                        ]
                    ),
                ]
            ]
        )
            ->add(
                'products',
                PositionsSelect::class,
                [
                    'entry_type' => TextType::class,
                    'allow_add' => true,
                    'entry_options' => [
                        'constraints' => [
                            new Type(
                                [
                                    'type' => 'string',
                                    'message' => QuickListErrors::getError(
                                        QuickListErrors::INVALID_VALUE
                                    )
                                ]
                            ),
                            new Length(
                                [
                                    'max' => 255,
                                    'maxMessage' => QuickListErrors::getError(
                                        QuickListErrors::INVALID_POSITION
                                    )
                                ]
                            ),
                        ]
                    ]
                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(['data_class' => QuickListModel::class]);
    }
}
