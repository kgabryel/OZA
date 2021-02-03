<?php

namespace App\Model\Supply;


use App\Entity\Supply\Supply;
use App\Model\Model;
use App\Entity\Supply\Alert as Entity;
use App\Entity\Alert\Alert as AlertEntity;
class Alert implements Model
{
    private ?float $amount;
    private Supply $supply;
    private ?AlertEntity $alert;
    private Entity $entity;
    public function __construct()
    {
        $this->amount = 0;
        $this->alert=null;
        $this->entity=new Entity();
    }

    public function getSupply(): Supply
    {
        return $this->supply;
    }


    public function setSupply(Supply $supply): void
    {
        $this->supply = $supply;
    }

    public function getAlert(): ?AlertEntity
    {
        return $this->alert;
    }

    public function setAlert(?AlertEntity $alert): void
    {
        $this->alert = $alert;
    }


    public function getAmount(): float
    {
        return $this->amount;
    }

    public function setAmount(?float $amount): void
    {
        if($amount === null ){
            $amount=0.0;
        }
        $this->amount = $amount;
    }

    public function setEntity($entity)
    {
        $this->entity=$entity;
        return $this;
    }

    public function getEntity()
    {
        $this->entity->setAmount($this->amount);
        $this->entity->setSupply($this->supply);
        $this->entity->setAlert($this->alert);
        return $this->entity;
    }
}