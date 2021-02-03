<?php

namespace App\Form\Product;

use App\Messages\ProductErrors;
use App\Model\Product\EditProduct;
use App\Repository\Product\ProductRepository;
use App\Validator\FindForUser\FindForUser;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Type;

class EditForm extends AbstractType
{
    private ProductRepository $repository;
    private UserInterface $user;

    public function __construct(
        ProductRepository $repository, TokenStorageInterface $tokenStorage
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
                    new NotBlank(
                        ['message' => ProductErrors::getError(ProductErrors::NAME_MISSING)]
                    ),
                    new Type(
                        [
                            'type' => 'string',
                            'message' => ProductErrors::getError(ProductErrors::INVALID_VALUE)
                        ]
                    ),
                    new Length(
                        [
                            'max' => 30,
                            'maxMessage' => ProductErrors::getError(ProductErrors::NAME_TOO_LONG)
                        ]
                    ),
                    new FindForUser(
                        [
                            'user' => $this->user,
                            'repository' => $this->repository,
                            'columnName' => 'name',
                            'id' => $options['id'],
                            'message' => ProductErrors::getError(ProductErrors::NAME_IN_USE),
                            'empty' => true
                        ]
                    )
                ]
            ]
        );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'data_class' => EditProduct::class,
                'id' => 0
            ]
        );
    }
}
