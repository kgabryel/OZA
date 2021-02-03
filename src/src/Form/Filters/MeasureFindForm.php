<?php

namespace App\Form\Filters;

use App\Field\MultiSelect;
use App\Model\Filters\Measure;
use App\Repository\MeasureRepository;
use App\Services\Collection\MeasureCollection;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class MeasureFindForm extends AbstractType
{
    private array $measures;

    public function __construct(
        MeasureRepository $repository, TokenStorageInterface $storage
    )
    {
        $user = $storage->getToken()
            ->getUser();
        $this->measures = MeasureCollection::fromEntity(
            $repository->findOneBy(
                [
                    'user' => $user,
                    'main' => null
                ]
            )
        );
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add(
            'name',
            null,
            ['label' => 'Nazwa']
        )
            ->add(
                'shortcut',
                null,
                ['label' => 'Skrót']
            )
            ->add(
                'types',
                MultiSelect::class,
                [
                    'label' => 'Typ',
                    'multiple' => true,
                    'choices' => [
                        'Główna' => 1,
                        'Podrzędna' => 2
                    ]
                ]
            )
            ->add(
                'measures',
                MultiSelect::class,
                [
                    'label' => 'Jednostka bazowa',
                    'multiple' => true,
                    'choices' => $this->measures
                ]
            )
            ->setMethod('GET');
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'data_class' => Measure::class,
                'csrf_protection' => false,
            ]
        );
    }

    public function getBlockPrefix()
    {
        return '';
    }
}
