<?php

namespace App\Form\Filters;

use App\Field\MaterialDate;
use App\Field\MultiSelect;
use App\Model\Filters\Shopping;
use App\Repository\MeasureRepository;
use App\Repository\Product\ProductRepository;
use App\Repository\Product\StuffRepository;
use App\Repository\ShopRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class ShoppingFindForm extends AbstractType
{
    private array $shops;
    private array $measures;
    private array $products;
    private array $stuffs;

    public function __construct(
        MeasureRepository $repository, ShopRepository $shopRepository,
        ProductRepository $productRepository, StuffRepository $stuffRepository,
        TokenStorageInterface $storage
    )
    {
        $user = $storage->getToken()
            ->getUser();
        $measures = $repository->findForUser($user);
        $this->measures = [];
        foreach ($measures as $measure) {
            $this->measures[$measure->getFull()] = $measure->getId();
        }
        $shops = $shopRepository->findForUser($user);
        $this->shops = [];
        foreach ($shops as $shop) {
            $this->shops[$shop->getName()] = $shop->getId();
        }
        $products = $productRepository->findForUser($user);
        $this->products = [];
        foreach ($products as $product) {
            $this->products[$product->getName()] = $product->getId();
        }
        $stuffs = $stuffRepository->findForUser($user);
        $this->stuffs = [];
        foreach ($stuffs as $stuff) {
            $this->stuffs[$stuff->getName()] = $stuff->getId();
        }
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add(
            'dateFrom',
            MaterialDate::class,
            ['label' => 'Data od']
        )
            ->add(
                'dateTo',
                MaterialDate::class,
                ['label' => 'Data do']
            )
            ->add(
                'shops',
                MultiSelect::class,
                [
                    'label' => 'Sklep',
                    'multiple' => true,
                    'choices' => $this->shops
                ]
            )
            ->add(
                'measures',
                MultiSelect::class,
                [
                    'label' => 'Jednostka bazowa',
                    'multiple' => true,
                    'choices' => $this->measures
                ]
            )
            ->add(
                'promotion',
                MultiSelect::class,
                [
                    'label' => 'Promocja',
                    'multiple' => true,
                    'choices' => [
                        'Tak' => 1,
                        'Nie' => 2
                    ]
                ]
            )
            ->add(
                'products',
                MultiSelect::class,
                [
                    'label' => 'Produkty',
                    'multiple' => true,
                    'choices' => $this->products
                ]
            )
            ->add(
                'stuffs',
                MultiSelect::class,
                [
                    'label' => 'Towary',
                    'multiple' => true,
                    'choices' => $this->stuffs
                ]
            )
            ->setMethod('GET');
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'data_class' => Shopping::class,
                'csrf_protection' => false
            ]
        );
    }

    public function getBlockPrefix()
    {
        return '';
    }
}
