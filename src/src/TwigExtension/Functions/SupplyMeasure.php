<?php

namespace App\TwigExtension\Functions;

use App\Repository\Product\ProductRepository;
use Symfony\Component\Form\FormView;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class SupplyMeasure extends AbstractExtension
{
    private ProductRepository $repository;

    public function __construct(ProductRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction(
                'supplyMeasure', [$this, 'execute']
            ),
        ];
    }

    public function execute(FormView $value)
    {
        if ($value->vars['valid'] && $value->vars['value'] > 0) {
            $measure = $this->repository->find($value->vars['value'])
                ->getMeasure();
            return sprintf('%s (%s)', $measure->getName(), $measure->getShortcut());
        }
        return '';
    }
}