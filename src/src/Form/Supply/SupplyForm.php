<?php

namespace App\Form\Supply;

use App\Entity\User;
use App\Field\MaterialSelect;
use App\Messages\SupplyErrors;
use App\Model\Supply;
use App\Repository\Product\ProductRepository;
use App\Repository\Supply\SupplyRepository;
use App\Transformer\ProductTransformer;
use App\Validator\BelongsToUser\BelongsToUser;
use App\Validator\Unique\Unique;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Validator\Constraints\GreaterThanOrEqual;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Type;

class SupplyForm extends AbstractType
{
    private ProductRepository $productRepository;
    private SupplyRepository $supplyRepository;
    private User $user;
    private array $products;

    public function __construct(
        TokenStorageInterface $tokenStorage, ProductRepository $productRepository,
        SupplyRepository $supplyRepository
    )
    {
        $this->productRepository = $productRepository;
        $this->supplyRepository = $supplyRepository;
        $this->user = $tokenStorage->getToken()
            ->getUser();
        $this->products = [];
        foreach ($productRepository->findWithoutSupply($this->user) as $product) {
            $this->products[$product['id']] = $product['name'];
        }
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add(
            'product',
            MaterialSelect::class,
            [
                'label' => 'Produkt',
                'error_bubbling' => false,
                'transformer' => new ProductTransformer($this->productRepository),
                'items' => $this->products,
                'constraints' => [
                    new NotBlank(
                        ['message' => SupplyErrors::getError(SupplyErrors::PRODUCT_MISSING)]
                    ),
                    new BelongsToUser(['user' => $this->user]),
                    new Unique(
                        [
                            'repository' => $this->supplyRepository,
                            'column' => 'product',
                            'message' => SupplyErrors::getError(SupplyErrors::PRODUCT_IN_USE)
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
                        )
                    ]
                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(['data_class' => Supply::class]);
    }
}
