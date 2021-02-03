<?php

namespace App\Form\Measures;

use App\Field\MaterialSelect;
use App\Messages\MeasureErrors;
use App\Model\Measures\SubMeasure;
use App\Repository\MeasureRepository;
use App\Services\Collection\MeasureCollection;
use App\Transformer\MeasureTransformer;
use App\Validator\BelongsToUser\BelongsToUser;
use App\Validator\FindForUser\FindForUser;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Validator\Constraints\GreaterThan;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Type;

class SubForm extends MainForm
{
    private array $measures;

    public function __construct(MeasureRepository $repository, TokenStorageInterface $tokenStorage)
    {
        parent::__construct($repository, $tokenStorage);
        $this->measures = MeasureCollection::toIndexedArray(
            $this->repository->findBy(
                [
                    'user' => $this->user,
                    'main' => null
                ]
            )
        );
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);
        $builder->add(
            'converter',
            NumberType::class,
            [
                'label' => 'Przelicznik',
                'constraints' => [
                    new NotBlank(
                        ['message' => MeasureErrors::getError(MeasureErrors::CONVERTER_MISSING)]
                    ),
                    new Type(
                        [
                            'type' => 'float',
                            'message' => MeasureErrors::getError(MeasureErrors::INVALID_VALUE)
                        ]
                    ),
                    new GreaterThan(
                        [
                            'value' => 0,
                            'message' => MeasureErrors::getError(MeasureErrors::INVALID_CONVERTER)
                        ]
                    )
                ]
            ]
        )
            ->add(
                'mainMeasure',
                MaterialSelect::class,
                [
                    'label' => 'Główna jednostka',
                    'transformer' => new MeasureTransformer($this->repository),
                    'items' => $this->measures,
                    'constraints' => [
                        new NotBlank(
                            ['message' => MeasureErrors::getError(MeasureErrors::MEASURE_MISSING)]
                        ),
                        new BelongsToUser(['user' => $this->user]),
                        new FindForUser(
                            [
                                'user' => $this->user,
                                'repository' => $this->repository,
                                'columnName' => 'id',
                                'message' => MeasureErrors::getError(
                                    MeasureErrors::INVALID_MEASURE
                                ),
                                'empty' => false,
                                'getter' => FindForUser::getIdGetter()
                            ]
                        ),
                    ]
                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'data_class' => SubMeasure::class
            ]
        );
    }
}
