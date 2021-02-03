<?php

namespace App\Form\Product;

use App\Field\MaterialSelect;
use App\Messages\ProductErrors;
use App\Model\Product\Product;
use App\Repository\MeasureRepository;
use App\Repository\Product\ProductRepository;
use App\Services\Collection\MeasureCollection;
use App\Transformer\MeasureTransformer;
use App\Validator\FindForUser\FindForUser;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Type;

class ProductForm extends AbstractType
{
    private ProductRepository $productRepository;
    private MeasureRepository $measureRepository;
    private UserInterface $user;
    private array $measures;

    public function __construct(
        ProductRepository $productRepository, MeasureRepository $measureRepository,
        TokenStorageInterface $tokenStorage
    )
    {
        $this->productRepository = $productRepository;
        $this->measureRepository = $measureRepository;
        $this->user = $tokenStorage->getToken()
            ->getUser();
        $this->measures = MeasureCollection::toIndexedArray(
            $this->measureRepository->findBy(
                [
                    'user' => $this->user,
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
                            'repository' => $this->productRepository,
                            'columnName' => 'name',
                            'numeric' => false,
                            'message' => ProductErrors::getError(ProductErrors::NAME_IN_USE),
                            'empty' => true
                        ]
                    )
                ]
            ]
        )
            ->add(
                'measure',
                MaterialSelect::class,
                [
                    'label' => 'Jednostka bazowa',
                    'transformer' => new MeasureTransformer($this->measureRepository),
                    'items' => $this->measures,
                    'constraints' => [
                        new NotBlank(
                            ['message' => ProductErrors::getError(ProductErrors::MEASURE_MISSING)]
                        ),
                        new FindForUser(
                            [
                                'user' => $this->user,
                                'repository' => $this->measureRepository,
                                'columnName' => 'id',
                                'message' => ProductErrors::getError(
                                    ProductErrors::INVALID_MEASURE
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
                'data_class' => Product::class,
            ]
        );
    }
}
