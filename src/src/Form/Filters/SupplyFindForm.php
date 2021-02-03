<?php

namespace App\Form\Filters;

use App\Field\MultiSelect;
use App\Model\Filters\Supply;
use App\Repository\MeasureRepository;
use App\Repository\Product\ProductRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class SupplyFindForm extends AbstractType
{
    private array $products;
    private array $measures;

    public function __construct(
        MeasureRepository $repository, ProductRepository $groupRepository,
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
        $products = $groupRepository->findBy(['user' => $user]);
        $this->products = [];
        foreach ($products as $product) {
            $this->products[$product->getName()] = $product->getId();
        }
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add(
            'amountMin',
            NumberType::class,
            [
                'label' => 'Ilość od',
                'invalid_message' => 'Wpisano błędną wartość.'
            ]
        )
            ->add(
                'amountMax',
                NumberType::class,
                [
                    'label' => 'Ilość do',
                    'invalid_message' => 'Wpisano błędną wartość.'
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
            ->setMethod('GET');
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'data_class' => Supply::class,
                'csrf_protection' => false
            ]
        );
    }

    public function getBlockPrefix()
    {
        return '';
    }
}
