<?php

namespace App\Transformer;

use App\Services\Collection\ListPositionCollection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Form\DataTransformerInterface;

class PositionTransformer implements DataTransformerInterface
{
    public function reverseTransform($value): ArrayCollection
    {
        if (null === $value) {
            return new ArrayCollection();
        }
        if (!$value instanceof ArrayCollection) {
            throw new \LogicException(
                sprintf(
                    'The %s can only be used with %s',
                    ArrayCollection::class,
                    __CLASS__
                )
            );
        }
        return new ArrayCollection(ListPositionCollection::asPositionList($value));
    }

    public function transform($value): ArrayCollection
    {
        if (null === $value) {
            return new ArrayCollection();
        }
        if (!$value instanceof ArrayCollection) {
            throw new \LogicException(
                sprintf(
                    'The %s can only be used with %s',
                    ArrayCollection::class,
                    __CLASS__
                )
            );
        }
        return new ArrayCollection(ListPositionCollection::fromArray($value->toArray()));
    }
}