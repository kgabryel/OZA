<?php

namespace App\Transformer;

use App\Entity\Product\Product;
use App\Repository\Product\ProductRepository;
use Symfony\Component\Form\DataTransformerInterface;

class ProductTransformer implements DataTransformerInterface
{
    private ProductRepository $repository;

    public function __construct(ProductRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @inheritDoc
     */
    public function reverseTransform($value)
    {
        if (null === $value) {
            return null;
        }
        if (0 === $value) {
            return null;
        }
        return $this->repository->find($value);
    }

    /**
     * @param Product $value
     *
     * @return int
     */
    public function transform($value): int
    {
        if (null === $value) {
            return 0;
        }
        if (!$value instanceof Product) {
            throw new \LogicException(
                sprintf(
                    'The %s can only be used with %s objects',
                    __CLASS__,
                    Product::class
                )
            );
        }
        return $value->getId();
    }
}