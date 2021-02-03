<?php

namespace App\Field;

use App\Entity\Measure;
use App\Messages\ShoppingErrors;
use App\Repository\MeasureRepository;
use App\Repository\Product\ProductRepository;
use App\Repository\Product\StuffRepository;
use App\Repository\ShopRepository;
use App\Services\Collection\MeasureCollection;
use App\Services\Collection\ShopCollection;
use App\Services\PositionFactory\PositionFactory;
use App\Transformer\MeasureTransformer;
use App\Transformer\ShopTransformer;
use App\Transformer\ShoppingTransformer;
use App\Validator\BelongsToUser\BelongsToUser;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints\GreaterThan;
use Symfony\Component\Validator\Constraints\NotBlank;

class ShoppingPosition extends AbstractType
{
    private MeasureRepository $measureRepository;
    private ShopRepository $shopRepository;
    private UserInterface $user;
    private PositionFactory $factory;
    private ProductRepository $productRepository;
    private StuffRepository $stuffRepository;

    public function __construct(
        MeasureRepository $measureRepository, TokenStorageInterface $tokenStorage,
        ShopRepository $shopRepository, PositionFactory $factory,
        ProductRepository $productRepository, StuffRepository $stuffRepository
    )
    {
        $this->measureRepository = $measureRepository;
        $this->shopRepository = $shopRepository;
        $this->productRepository = $productRepository;
        $this->stuffRepository = $stuffRepository;
        $this->factory = $factory;
        $this->user = $tokenStorage->getToken()
            ->getUser();
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->addModelTransformer(new ShoppingTransformer($this->factory));
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
                'shop',
                MaterialSelect::class,
                [
                    'error_bubbling' => true,
                    'label' => 'Sklep',
                    'transformer' => new ShopTransformer($this->shopRepository),
                    'items' => ShopCollection::toIndexedArray(
                        $this->shopRepository->findForUser($this->user)
                    ),
                    'constraints' => [
                        new NotBlank(
                            ['message' => ShoppingErrors::getError(ShoppingErrors::SHOP_MISSING)]
                        ),
                        new BelongsToUser(['user' => $this->user]),
                    ]
                ]
            )
            ->add(
                'price',
                null,
                [
                    'error_bubbling' => true,
                    'label' => 'Cena',
                    'constraints' => [
                        new NotBlank(
                            ['message' => ShoppingErrors::getError(ShoppingErrors::PRICE_MISSING)]
                        ),
                        new GreaterThan(
                            [
                                'value' => 0,
                                'message' => ShoppingErrors::getError(
                                    ShoppingErrors::PRICE_TOO_SMALL
                                )
                            ]
                        )
                    ]
                ]
            )
            ->add(
                'amount',
                null,
                [
                    'error_bubbling' => true,
                    'constraints' => [
                        new NotBlank(
                            ['message' => ShoppingErrors::getError(ShoppingErrors::AMOUNT_MISSING)]
                        ),
                        new GreaterThan(
                            [
                                'value' => 0,
                                'message' => ShoppingErrors::getError(
                                    ShoppingErrors::AMOUNT_TOO_SMALL
                                )
                            ]
                        )
                    ]
                ]
            )
            ->add(
                'date',
                MaterialDate::class,
                [
                    'error_bubbling' => false,
                    'label' => 'Data zakupu'
                ]
            )
            ->add(
                'promotion',
                MaterialSwitch::class,
                [
                    'on' => 'Tak',
                    'off' => 'Nie'
                ]
            );
        $builder->addEventListener(
            FormEvents::PRE_SUBMIT,
            function(FormEvent $event) {
                $this->modifyMeasureInput($event);
            }
        );
        parent::buildForm($builder, $options);
    }

    private function modifyMeasureInput(FormEvent $event): void
    {
        $id = $event->getData()['position'] === "" ? 0 : $event->getData()['position'];
        $type = $event->getData()['type'] === "Towar" ? "Produkt" : $event->getData()['type'];
        if ($id === 0) {
            return;
        }
        if ($type === "Towar") {
            $measure = $this->getMeasureFromStuff($id);
        } else {
            $measure = $this->getMeasureFromProduct($id);
        }
        if ($measure === null) {
            return;
        }
        $default = $measure->getId();
        $items = MeasureCollection::fromEntity($measure);
        $event->getForm()
            ->remove('measure');
        $event->getForm()
            ->add(
                'measure',
                MaterialSelect::class,
                $this->getMeasureOptions($measure, $items, $default)
            );
    }

    private function getMeasureOptions(Measure $measure, array $items = [], int $default = 0): array
    {
        return [
            'error_bubbling' => true,
            'label' => 'Jednostka',
            'transformer' => new MeasureTransformer($this->measureRepository),
            'constraints' => [
                new NotBlank(
                    ['message' => ShoppingErrors::getError(ShoppingErrors::MEASURE_MISSING)]
                ),
                new BelongsToUser(['user' => $this->user]),
            ],
            'data' => $measure,
            'data_class' => null,
            'default' => $default,
            'items' => $items
        ];
    }

    private function getMeasureFromStuff($id): ?Measure
    {
        $stuff = $this->stuffRepository->find($id);
        if ($stuff === null) {
            return null;
        }
        return $stuff->getMeasure();
    }

    private function getMeasureFromProduct($id): ?Measure
    {
        $product = $this->productRepository->find($id);
        if ($product === null) {
            return null;
        }
        return $product->getMeasure();
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'multiple' => true,
                'compound' => true,
            ]
        );
    }
}
