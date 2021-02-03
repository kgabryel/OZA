<?php

namespace App\Model\Product;

use App\Entity\Alert\Alert;
use App\Entity\Measure;
use App\Entity\Product\Product as Entity;
use App\Entity\Product\Stuff;
use App\Entity\User;
use App\Enums\ProductPosition;
use App\Repository\Alert\AlertRepository;
use App\Services\MeasureFinder;
use App\Services\PositionFactory\PositionFactory;

class Position
{
    private float $amount;
    private string $type;
    private ?Entity $product;
    private ?Stuff $stuff;
    private ?Measure $measure;
    /** @var Alert[] */
    private array $alerts;

    public function __construct(
        array $data, PositionFactory $factory, MeasureFinder $finder, User $user,
        AlertRepository $repository
    )
    {
        $this->alerts = [];
        $this->amount = (float)($data['amount'] ?? 0);
        if ($data['type'] === null) {
            $data['type'] = ProductPosition::getValue(ProductPosition::PRODUCT);
        }
        $this->type = in_array(
            $data['type'],
            [
                ProductPosition::getValue(ProductPosition::PRODUCT),
                ProductPosition::getValue(ProductPosition::STUFF)
            ],
            true
        ) ? $data['type'] : ProductPosition::getValue(ProductPosition::PRODUCT);
        $concreteFactory = $factory->get($this->type, (int)($data['position'] ?? 0));
        $this->product = $concreteFactory->getProduct();
        $this->stuff = $concreteFactory->getStuff();
        $this->measure = $finder->get(
            $this->product,
            $this->stuff,
            (int)($data['measure'] ?? 0)
        );
        if (isset($data['alerts'])) {
            foreach ($data['alerts'] as $id) {
                $alert = $repository->findOneBy(
                    [
                        'id' => $id,
                        'user' => $user,
                        'isActive' => true
                    ]
                );
                if ($alert !== null) {
                    $this->alerts[] = $alert;
                }
            }
        }
    }

    public function getAmount(): float
    {
        return $this->amount;
    }

    public function getType()
    {
        return $this->type;
    }

    public function getAlerts(): array
    {
        return $this->alerts;
    }

    public function getMeasureRaw(): int
    {
        if ($this->measure === null) {
            return 0;
        }
        return $this->measure->getId();
    }

    public function getMeasure(): ?Measure
    {
        return $this->measure;
    }

    public function getProduct(): ?Entity
    {
        return $this->product;
    }

    public function getStuff(): ?Stuff
    {
        return $this->stuff;
    }

    public function getPosition(): int
    {
        if ($this->product === null) {
            return $this->stuff->getId();
        }
        return $this->product->getId();
    }
}