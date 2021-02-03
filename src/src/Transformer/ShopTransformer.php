<?php

namespace App\Transformer;

use App\Entity\Shop;
use App\Repository\ShopRepository;
use Symfony\Component\Form\DataTransformerInterface;

class ShopTransformer implements DataTransformerInterface
{
    private ShopRepository $repository;

    public function __construct(ShopRepository $repository)
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
     * @param Shop $value
     *
     * @return int
     */
    public function transform($value)
    {
        if (null === $value) {
            return 0;
        }
        if (!$value instanceof Shop) {
            throw new \LogicException(
                sprintf(
                    'The %s can only be used with %s objects',
                    __CLASS__,
                    Shop::class
                )
            );
        }
        return $value->getId();
    }
}