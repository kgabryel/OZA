<?php

namespace App\Transformer;

use App\Entity\Alert\Type;
use App\Repository\Alert\TypeRepository;
use Symfony\Component\Form\DataTransformerInterface;

class AlertTypeTransformer implements DataTransformerInterface
{
    private TypeRepository $repository;

    public function __construct(TypeRepository $repository)
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
     * @param Type $value
     *
     * @return int
     */
    public function transform($value): int
    {
        if (null === $value) {
            return 0;
        }
        if (!$value instanceof Type) {
            throw new \LogicException(
                sprintf(
                    'The %s can only be used with %s objects',
                    __CLASS__,
                    Type::class
                )
            );
        }
        return $value->getId();
    }
}