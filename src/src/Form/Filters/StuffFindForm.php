<?php

namespace App\Form\Filters;

use App\Field\MultiSelect;
use App\Model\Filters\Stuff;
use App\Repository\MeasureRepository;
use App\Repository\Product\ProductRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class StuffFindForm extends AbstractType
{
    private array $measures;
    private array $products;

    public function __construct(
        MeasureRepository $repository, ProductRepository $productRepository,
        TokenStorageInterface $storage
    )
    {
        $user = $storage->getToken()
            ->getUser();
        $measures = $repository->findBy(['user' => $user]);
        $this->measures = [];
        foreach ($measures as $measure) {
            $this->measures[$measure->getFull()] = $measure->getId();
        }
        $products = $productRepository->findBy(['user' => $user]);
        $this->products = [];
        foreach ($products as $product) {
            $this->products[$product->getName()] = $product->getId();
        }
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add(
            'name',
            null,
            ['label' => 'Nazwa']
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
                'measures',
                MultiSelect::class,
                [
                    'label' => 'Jednostka bazowa',
                    'multiple' => true,
                    'choices' => $this->measures
                ]
            )
            ->add(
                'productMeasures',
                MultiSelect::class,
                [
                    'label' => 'Jednostka bazowa produktu',
                    'multiple' => true,
                    'choices' => $this->measures
                ]
            )
            ->setMethod('GET');
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'data_class' => Stuff::class,
                'csrf_protection' => false,
            ]
        );
    }

    public function getBlockPrefix()
    {
        return '';
    }
}
