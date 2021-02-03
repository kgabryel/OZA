<?php

namespace App\Transformer;

use App\Entity\Measure;
use App\Repository\MeasureRepository;
use Symfony\Component\Form\DataTransformerInterface;

class MeasureTransformer implements DataTransformerInterface
{
    private MeasureRepository $repository;

    public function __construct(MeasureRepository $repository)
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
     * @param Measure $value
     *
     * @return int
     */
    public function transform($value): int
    {
        if (null === $value) {
            return 0;
        }
        if (!$value instanceof Measure) {
            throw new \LogicException(
                sprintf(
                    'The %s can only be used with %s objects',
                    __CLASS__,
                    Measure::class
                )
            );
        }
        return $value->getId();
    }
}