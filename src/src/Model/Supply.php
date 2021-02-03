<?php

namespace App\Model;

use App\Entity\Product\Product;
use App\Entity\Supply\Supply as Entity;


class Supply implements Model
{
    private ?Product $product;
    private float $amount;
    private Entity $supply;

    public function __construct()
    {
        $this->product = null;
        $this->amount = 0;
        $this->supply = new Entity();
    }

    public function getProduct(): ?Product
    {
        return $this->product;
    }


    public function setProduct(?Product $product): void
    {
        $this->product = $product;
    }


    public function getAmount()
    {
        return $this->amount;
    }


    public function setAmount(?float $amount): void
    {
        if ($amount === null) {
            $amount = 0.0;
        }
        $this->amount = $amount;
    }

    public function getEntity(): Entity
    {
        $this->supply->setProduct($this->product);
        $this->supply->setAmount($this->amount);
        return $this->supply;
    }

    public function setEntity($entity)
    {
        $this->supply=$entity;
        return $this;
    }
}