<?php

namespace App\Form;

use App\Entity\User;
use App\Field\MaterialSelect;
use App\Messages\StuffErrors;
use App\Model\Product\Stuff;
use App\Repository\MeasureRepository;
use App\Repository\Product\ProductRepository;
use App\Repository\Product\StuffRepository;
use App\Services\Collection\MeasureCollection;
use App\Services\Collection\ProductCollection;
use App\Transformer\ProductTransformer;
use App\Transformer\MeasureTransformer;
use App\Validator\BelongsToProduct\BelongsToProduct;
use App\Validator\BelongsToUser\BelongsToUser;
use App\Validator\FindForUser\FindForUser;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Type;

class StuffForm extends AbstractType
{
    private MeasureRepository $measureRepository;
    private StuffRepository $stuffRepository;
    private ProductRepository $productRepository;
    private User $user;

    public function __construct(
        MeasureRepository $measureRepository, TokenStorageInterface $tokenStorage,
        StuffRepository $stuffRepository, ProductRepository $productRepository
    )
    {
        $this->measureRepository = $measureRepository;
        $this->stuffRepository = $stuffRepository;
        $this->productRepository = $productRepository;
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
                    new NotBlank(['message' => StuffErrors::getError(StuffErrors::NAME_MISSING)]),
                    new Type(
                        [
                            'type' => 'string',
                            'message' => StuffErrors::getError(StuffErrors::INVALID_VALUE)
                        ]
                    ),
                    new Length(
                        [
                            'max' => 30,
                            'maxMessage' => StuffErrors::getError(StuffErrors::NAME_TOO_LONG)
                        ]
                    ),
                    new FindForUser(
                        [
                            'user' => $this->user,
                            'repository' => $this->stuffRepository,
                            'columnName' => 'name',
                            'message' => StuffErrors::getError(StuffErrors::NAME_IN_USE),
                            'empty' => true,
                            'numeric' => false
                        ]
                    )
                ]
            ]
        )
            ->add(
                'product',
                MaterialSelect::class,
                [
                    'label' => 'Produkt',
                    'error_bubbling' => false,
                    'transformer' => new ProductTransformer($this->productRepository),
                    'items' => ProductCollection::toIndexedArray(
                        $this->productRepository->findForUser($this->user)
                    ),
                    'constraints' => [
                        new NotBlank(
                            ['message' => StuffErrors::getError(StuffErrors::PRODUCT_MISSING)]
                        ),
                        new BelongsToUser(['user' => $this->user,]),
                    ]
                ]
            )
            ->add(
                'measure',
                MaterialSelect::class,
                $this->getMeasureOptions()
            );
        $builder->addEventListener(
            FormEvents::PRE_SUBMIT,
            function(FormEvent $event) {
                $this->modifyMeasureInput($event);
            }
        );
    }

    private function modifyMeasureInput(FormEvent $event): void
    {
        $productId = $event->getData()['product'] === "" ? 0 : $event->getData()['product'];
        if ($productId === 0) {
            return;
        }
        $product = $this->productRepository->find($productId);
        if ($product === null) {
            return;
        }
        $measure = $product->getMeasure();
        $event->getForm()
            ->remove('measure');
        $event->getForm()
            ->add(
                'measure',
                MaterialSelect::class,
                $this->getMeasureOptions(
                    MeasureCollection::fromEntity($measure),
                    [
                        new BelongsToProduct(
                            [
                                'product' => $product,
                                'message' => StuffErrors::getError(StuffErrors::INVALID_MEASURE)
                            ]
                        )
                    ],
                    true,
                    $measure->getId()
                )
            );
    }

    private function getMeasureOptions(
        array $items = [], array $constraints = [], bool $enabled = false, int $default = 0
    ): array
    {
        $constraints [] = new NotBlank(
            ['message' => StuffErrors::getError(StuffErrors::MEASURE_MISSING)]
        );
        $constraints [] = new BelongsToUser(['user' => $this->user]);
        return [
            'label' => 'Jednostka bazowa',
            'error_bubbling' => false,
            'transformer' => new MeasureTransformer($this->measureRepository),
            'enabled' => $enabled,
            'items' => $items,
            'default' => $default,
            'constraints' => $constraints
        ];
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(['data_class' => Stuff::class]);
    }
}
