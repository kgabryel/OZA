<?php

namespace App\Form\Supply;

use App\Entity\User;
use App\Messages\SupplyErrors;
use App\Model\Supply\Alert;
use App\Repository\Alert\AlertRepository;
use App\Repository\Supply\AlertRepository as SupplyAlertRepository;
use App\Transformer\AlertTransformer;
use App\Validator\BelongsToUser\BelongsToUser;
use App\Validator\UniqueForSupply\UniqueForSupply;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Validator\Constraints\GreaterThanOrEqual;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Type;

class AlertForm extends AbstractType
{
    private AlertRepository $alertRepository;
    private SupplyAlertRepository $supplyAlertRepository;
    private User $user;

    public function __construct(
        AlertRepository $alertRepository, SupplyAlertRepository $supplyAlertRepository,
        TokenStorageInterface $storage
    )
    {
        $this->alertRepository = $alertRepository;
        $this->supplyAlertRepository = $supplyAlertRepository;
        $this->user = $storage->getToken()
            ->getUser();
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add(
            'alert',
            HiddenType::class,
            [
                'constraints' => [
                    new NotBlank(
                        ['message' => SupplyErrors::getError(SupplyErrors::ALERT_MISSING)]
                    ),
                    new BelongsToUser(['user' => $this->user]),
                    new UniqueForSupply(
                        [
                            'repository' => $this->supplyAlertRepository,
                            'id' => $options['id'],
                            'column' => 'alert',
                            'message' => SupplyErrors::getError(SupplyErrors::ALERT_IN_USE)
                        ]
                    )
                ]
            ]
        )
            ->add(
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
                        ),
                        new UniqueForSupply(
                            [
                                'repository' => $this->supplyAlertRepository,
                                'id' => $options['id'],
                                'column' => 'amount',
                                'message' => SupplyErrors::getError(SupplyErrors::AMOUNT_IN_USE)
                            ]
                        )
                    ]
                ]
            );
        $builder->get('alert')
            ->addModelTransformer(new AlertTransformer($this->alertRepository));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'data_class' => Alert::class,
                'id' => 0
            ]
        );
    }
}
