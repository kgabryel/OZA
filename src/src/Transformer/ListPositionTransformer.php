<?php

namespace App\Transformer;

use App\Entity\User;
use App\Enums\ProductPosition;
use App\Model\Product\Position;
use App\Repository\Alert\AlertRepository;
use App\Services\Collection\AlertCollection;
use App\Services\MeasureFinder;
use App\Services\PositionFactory\PositionFactory;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class ListPositionTransformer implements DataTransformerInterface
{
    private PositionFactory $factory;
    private MeasureFinder $finder;
    private User $user;
    private AlertRepository $repository;

    public function __construct(
        PositionFactory $factory, MeasureFinder $finder, TokenStorageInterface $tokenStorage,
        AlertRepository $repository
    )
    {
        $this->factory = $factory;
        $this->finder = $finder;
        $this->user = $tokenStorage->getToken()
            ->getUser();
        $this->repository = $repository;
    }

    /**
     * @inheritDoc
     */
    public function reverseTransform($value)
    {
        return new Position($value, $this->factory, $this->finder, $this->user, $this->repository);
    }

    public function transform($value)
    {
        if (null === $value) {
            return [
                'position' => 0,
                'measure' => 0,
                'amount' => 0,
                'type' => ProductPosition::getValue(ProductPosition::PRODUCT),
                'alerts' => []
            ];
        }
        if (!$value instanceof Position) {
            throw new \LogicException(
                sprintf(
                    'The %s can only be used with %s objects',
                    __CLASS__,
                    Position::class
                )
            );
        }
        return [
            'position' => $value->getPosition(),
            'measure' => $value->getMeasureRaw(),
            'amount' => $value->getAmount(),
            'type' => $value->getType(),
            'alerts' => AlertCollection::toPositionAlerts($value->getAlerts(), $this->user)
        ];
    }
}