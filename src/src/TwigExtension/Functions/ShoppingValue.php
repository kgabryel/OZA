<?php

namespace App\TwigExtension\Functions;

use App\Enums\ProductPosition;
use App\Repository\Product\StuffRepository;
use App\Repository\Product\ProductRepository;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class ShoppingValue extends AbstractExtension
{
    private StuffRepository $stuffRepository;
    private ProductRepository $productRepository;

    public function __construct(
        StuffRepository $stuffRepository, ProductRepository $productRepository
    )
    {
        $this->stuffRepository = $stuffRepository;
        $this->productRepository = $productRepository;
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction(
                'shoppingValue', [
                    $this,
                    'execute'
                ]
            ),
        ];
    }

    public function execute(array $data): string
    {
        if (!isset($data['type'])) {
            return '';
        }
        if ($data['type'] === ProductPosition::getValue(ProductPosition::STUFF)) {
            return $this->stuffRepository->find($data['position'])
                ->getName();
        }
        return $this->productRepository->find($data['position'])
            ->getName();
    }
}