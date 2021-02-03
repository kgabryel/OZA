<?php

namespace App\Form\Filters;

use App\Field\MultiSelect;
use App\Model\Filters\Alert;
use App\Repository\Alert\TypeRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AlertFindForm extends AbstractType
{
    private array $types;

    public function __construct(TypeRepository $repository)
    {
        $types = $repository->findAll();
        $this->types = [];
        foreach ($types as $type) {
            $this->types[$type->getName()] = $type->getId();
        }
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add(
            'description',
            null,
            ['label' => 'Treść']
        )
            ->add(
                'types',
                MultiSelect::class,
                [
                    'label' => 'Typ',
                    'multiple' => true,
                    'choices' => $this->types
                ]
            )
            ->add(
                'statuses',
                MultiSelect::class,
                [
                    'label' => 'Status',
                    'multiple' => true,
                    'choices' => [
                        'Aktywne' => 1,
                        'Nieaktywne' => 2
                    ]
                ]
            )
            ->setMethod('GET');
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'data_class' => Alert::class,
                'csrf_protection' => false,
            ]
        );
    }

    public function getBlockPrefix()
    {
        return '';
    }
}
