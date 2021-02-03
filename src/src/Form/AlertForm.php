<?php

namespace App\Form;

use App\Field\MaterialSelect;
use App\Field\MaterialSwitch;
use App\Messages\AlertErrors;
use App\Model\Alert;
use App\Repository\Alert\TypeRepository;
use App\Services\Collection\AlertTypeCollection;
use App\Transformer\AlertTypeTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Type;

class AlertForm extends AbstractType
{
    private TypeRepository $repository;

    public function __construct(TypeRepository $repository)
    {
        $this->repository = $repository;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add(
            'description',
            TextareaType::class,
            [
                'label' => 'Treść',
                'constraints' => [
                    new NotBlank(
                        ['message' => AlertErrors::getError(AlertErrors::INVALID_DESCRIPTION)]
                    ),
                    new Type(
                        [
                            'type' => 'string',
                            'message' => AlertErrors::getError(AlertErrors::INVALID_VALUE)
                        ]
                    )
                ]
            ]
        )
            ->add(
                'type',
                MaterialSelect::class,
                [
                    'label' => 'Typ',
                    'transformer' => new AlertTypeTransformer($this->repository),
                    'items' => AlertTypeCollection::toIndexedArray($this->repository->findAll()),
                    'constraints' => [
                        new NotBlank(
                            ['message' => AlertErrors::getError(AlertErrors::INVALID_TYPE)]
                        ),
                    ]
                ]
            )
            ->add('active', MaterialSwitch::class);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'data_class' => Alert::class
            ]
        );
    }
}
