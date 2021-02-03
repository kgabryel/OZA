<?php

namespace App\TwigExtension\Functions;

use App\Enums\ProductPosition;
use App\Repository\MeasureRepository;
use App\Repository\Product\StuffRepository;
use App\Repository\Product\ProductRepository;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class PositionValue extends AbstractExtension
{
    private MeasureRepository $measureRepository;
    private StuffRepository $stuffRepository;
    private ProductRepository $productRepository;

    public function __construct(
        MeasureRepository $measureRepository, StuffRepository $stuffRepository,
        ProductRepository $productRepository
    )
    {
        $this->measureRepository = $measureRepository;
        $this->stuffRepository = $stuffRepository;
        $this->productRepository = $productRepository;
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction(
                'positionValue', [
                    $this,
                    'execute'
                ]
            ),
        ];
    }

    public function execute(array $data): string
    {
        if ($data['type'] === ProductPosition::getValue(ProductPosition::STUFF)) {
            $position = $this->stuffRepository->find($data['position'])
                ->getName();
        } else {
            $position = $this->productRepository->find($data['position'])
                ->getName();
        }
        $measure = $this->measureRepository->find($data['measure']);
        return sprintf('%s - %s %s', $position, $data['amount'], $measure->getFull());
    }
}