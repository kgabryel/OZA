<?php

namespace App\Form;

use App\Field\MaterialDate;
use App\Field\MaterialSelect;
use App\Field\ShoppingPosition;
use App\Repository\ShopRepository;
use App\Services\Collection\ShopCollection;
use App\Transformer\ShopTransformer;
use App\Validator\CorrectMeasure\CorrectMeasure;
use App\Validator\CorrectPosition\CorrectPosition;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class ShoppingForm extends AbstractType
{
    private ShopRepository $repository;
    private UserInterface $user;

    public function __construct(
        ShopRepository $repository, TokenStorageInterface $tokenStorage
    )
    {
        $this->repository = $repository;
        $this->user = $tokenStorage->getToken()
            ->getUser();
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add(
            'baseShop',
            MaterialSelect::class,
            [
                'label' => 'Sklep',
                'transformer' => new ShopTransformer($this->repository),
                'items' => ShopCollection::toIndexedArray(
                    $this->repository->findForUser($this->user)
                )
            ]
        )
            ->add(
                'date',
                MaterialDate::class,
                [
                    'label' => 'Data zakupów',
                    'data' => (new \DateTime())->format('Y-m-d')
                ]
            )
            ->add(
                'positions',
                CollectionType::class,
                [
                    'entry_type' => ShoppingPosition::class,
                    'allow_add' => true,
                    'allow_extra_fields' => true,
                    'entry_options' => [
                        'error_bubbling' => false,
                        'constraints' => [
                            new CorrectPosition(['user' => $this->user]),
                            new CorrectMeasure()
                        ]
                    ]
                ],
            );
        parent::buildForm($builder, $options);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'compound' => true
            ]
        );
    }
}
