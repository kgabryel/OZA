<?php

namespace App\Form;

use App\Messages\ShopErrors;
use App\Model\Shop;
use App\Repository\ShopRepository;
use App\Validator\FindForUser\FindForUser;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Type;

class ShopForm extends AbstractType
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
            'name',
            null,
            [
                'label' => 'Nazwa',
                'constraints' => [
                    new NotBlank(['message' => 'Nazwa nie została podana.']),
                    new Type(
                        [
                            'type' => 'string',
                            'message' => ShopErrors::getError(ShopErrors::INVALID_VALUE)
                        ]
                    ),
                    new Length(
                        [
                            'max' => 40,
                            'maxMessage' => ShopErrors::getError(ShopErrors::NAME_TOO_LONG)
                        ]
                    ),
                    new FindForUser(
                        [
                            'user' => $this->user,
                            'repository' => $this->repository,
                            'columnName' => 'name',
                            'id' => $options['id'],
                            'message' => ShopErrors::getError(ShopErrors::SHOP_IN_USE),
                            'empty' => true,
                            'numeric' => false
                        ]
                    )
                ]
            ]
        )
            ->add(
                'description',
                TextareaType::class,
                [
                    'label' => 'Opis'
                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'data_class' => Shop::class,
                'id' => 0,
            ]
        );
    }
}
