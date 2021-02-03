<?php

namespace App\Model\Product;

use App\Entity\Measure;
use App\Entity\Product\Stuff as Entity;
use App\Entity\Product\Product;


class Stuff
{
    private ?string $name;
    private ?Measure $measure;
    private ?Product $product;

    public function __construct()
    {
        $this->name = null;
        $this->measure = null;
        $this->product = null;
    }


    public function getProduct(): ?Product
    {
        return $this->product;
    }


    public function setProduct(?Product $product): void
    {
        $this->product = $product;
    }

    /**
     * @return mixed
     */
    public function getMeasure()
    {
        return $this->measure;
    }

    /**
     * @param mixed $measure
     */
    public function setMeasure($measure): void
    {
        $this->measure = $measure;
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name): void
    {
        $this->name = $name;
    }


    public function getEntity(): Entity
    {
        $entity = new Entity();
        $entity->setName($this->name);
        $entity->setProduct($this->product);
        $entity->setMeasure($this->measure);
        return $entity;
    }

}