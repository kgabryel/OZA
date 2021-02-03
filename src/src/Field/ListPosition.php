<?php

namespace App\Field;

use App\Entity\User;
use App\Messages\MeasureErrors;
use App\Messages\ProductsListErrors;
use App\Repository\Alert\AlertRepository;
use App\Repository\MeasureRepository;
use App\Services\MeasureFinder;
use App\Services\PositionFactory\PositionFactory;
use App\Transformer\ListPositionTransformer;
use App\Validator\FindForUser\FindForUser;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Validator\Constraints\GreaterThan;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\NotNull;

class ListPosition extends AbstractType
{
    private PositionFactory $factory;
    private MeasureFinder $finder;
    private TokenStorageInterface $token;
    private AlertRepository $alertRepository;
    private User $user;
    private MeasureRepository $measureRepository;

    public function __construct(
        PositionFactory $factory, MeasureFinder $finder, TokenStorageInterface $tokenStorage,
        AlertRepository $alertRepository, MeasureRepository $measureRepository
    )
    {
        $this->factory = $factory;
        $this->finder = $finder;
        $this->token = $tokenStorage;
        $this->alertRepository = $alertRepository;
        $this->measureRepository = $measureRepository;
        $this->user = $tokenStorage->getToken()
            ->getUser();
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->addModelTransformer(
            new ListPositionTransformer(
                $this->factory, $this->finder, $this->token, $this->alertRepository
            )
        );
        $builder->add(
            'position',
            HiddenType::class,
            ['error_bubbling' => true]
        )
            ->add(
                'type',
                HiddenType::class,
                ['error_bubbling' => false]
            )
            ->add(
                'measure',
                HiddenType::class,
                [
                    'error_bubbling' => true,
                    'constraints' => [
                        new NotNull(
                            [
                                'message' => ProductsListErrors::getError(
                                    ProductsListErrors::MEASURE_MISSING
                                )
                            ]
                        ),
                        new FindForUser(
                            [
                                'user' => $this->user,
                                'repository' => $this->measureRepository,
                                'columnName' => 'id',
                                'message' => MeasureErrors::getError(
                                    MeasureErrors::INVALID_MEASURE
                                ),
                                'empty' => false,
                                'getter' => FindForUser::getSimpleGetter()
                            ]
                        ),
                    ]
                ]
            )
            ->add(
                'amount',
                HiddenType::class,
                [
                    'error_bubbling' => true,
                    'constraints' => [
                        new NotBlank(
                            [
                                'message' => ProductsListErrors::getError(
                                    ProductsListErrors::AMOUNT_MISSING
                                )
                            ]
                        ),
                        new GreaterThan(
                            [
                                'value' => 0,
                                'message' => ProductsListErrors::getError(
                                    ProductsListErrors::AMOUNT_TOO_SMALL
                                )
                            ]
                        )
                    ]
                ]
            )
            ->add(
                'alerts',
                CollectionType::class,
                [
                    'entry_type' => HiddenType::class,
                    'allow_add' => true,
                    'allow_extra_fields' => true,
                    'entry_options' => [
                        'error_bubbling' => false
                    ]
                ],
            );
        parent::buildForm($builder, $options);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'multiple' => true,
                'compound' => true
            ]
        );
    }
}
