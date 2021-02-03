<?php

namespace App\Model\Supply;


use App\Entity\Supply\Supply;
use App\Model\Model;

class Edit implements Model
{
    private float $amount;
    private Supply $supply;

    public function __construct()
    {
        $this->amount = 0;
    }

    public function getAmount(): float
    {
        return $this->amount;
    }

    public function setAmount(float $amount): void
    {
        $this->amount = $amount;
    }

    public static function fromEntity(Supply $supply): self
    {
        $model = new self();
        $model->setAmount($supply->getAmount());
        return $model;
    }

    public function setEntity($entity)
    {
        $this->supply = $entity;
        return $this;
    }

    public function getEntity()
    {
        $this->supply->setAmount($this->amount);
        return $this->supply;
    }
}