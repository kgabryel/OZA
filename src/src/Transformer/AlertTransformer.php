<?php

namespace App\Transformer;

use App\Entity\Alert\Alert;
use App\Entity\Measure;
use App\Repository\Alert\AlertRepository;
use Symfony\Component\Form\DataTransformerInterface;

class AlertTransformer implements DataTransformerInterface
{
    private AlertRepository $repository;

    public function __construct(AlertRepository $repository)
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
        if (!$value instanceof Alert) {
            throw new \LogicException(
                sprintf(
                    'The %s can only be used with %s objects',
                    __CLASS__,
                    Alert::class
                )
            );
        }
        return $value->getId();
    }
}