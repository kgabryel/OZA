<?php

namespace App\Transformer;

use App\Entity\Product\Product;
use App\Entity\Product\Stuff;
use App\Model\Shopping;
use App\Services\PositionFactory\PositionFactory;
use Symfony\Component\Form\DataTransformerInterface;

class ShoppingTransformer implements DataTransformerInterface
{
    private PositionFactory $factory;

    public function __construct(PositionFactory $factory)
    {
        $this->factory = $factory;
    }

    /**
     * @inheritDoc
     */
    public function reverseTransform($value)
    {
        return new Shopping($value, $this->factory);
    }

    public function transform($value)
    {
        if (null === $value) {
            return [
                'position' => 0,
                'measure' => 0,
                'amount' => 0,
                'type' => 'Produkt',
            ];
        }
        if (!$value instanceof Shopping) {
            throw new \LogicException(
                sprintf(
                    'The %s can only be used with %s objects',
                    __CLASS__,
                    Shopping::class
                )
            );
        }
        /** @var Product|Stuff $position */
        $position = $value->getProduct() ?? $value->getStuff();
        return [
            'position' => $position->getId(),
            'measure' => $value->getMeasure(),
            'amount' => $value->getAmount(),
            'type' => $value->getType(),
            'date' => $value->getDate()
                ->format('Y-m-d')
        ];
    }
}