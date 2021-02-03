<?php

namespace App\Form\Supply;

use App\Messages\SupplyErrors;
use App\Model\Supply\Edit;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\GreaterThanOrEqual;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Type;

class EditForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add(
            'amount',
            NumberType::class,
            [
                'label' => 'Ilość',
                'constraints' => [
                    new NotBlank(
                        ['message' => SupplyErrors::getError(SupplyErrors::AMOUNT_MISSING)]
                    ),
                    new Type(
                        [
                            'type' => 'float',
                            'message' => SupplyErrors::getError(SupplyErrors::INVALID_VALUE)
                        ]
                    ),
                    new GreaterThanOrEqual(
                        [
                            'value' => 0,
                            'message' => SupplyErrors::getError(SupplyErrors::AMOUNT_TOO_SMALL)
                        ]
                    )
                ]
            ]
        );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(['data_class' => Edit::class]);
    }
}
