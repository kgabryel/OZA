<?php

namespace App\Model\Product;

use App\Entity\Measure;
use App\Entity\Product\Product as Entity;
use App\Services\Makers\UsersModel;


class Product implements UsersModel
{
    private ?string $name;
    private ?Measure $measure;

    public function __construct()
    {
        $this->name = null;
        $this->measure = null;
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

    /**
     * @return Entity
     */
    public function getEntity(): Entity
    {
        $entity = new Entity();
        $entity->setName($this->name);
        $entity->setMeasure($this->measure);
        return $entity;
    }

    public static function fromEntity(Entity $entity): self
    {
        $product = new self();
        $product->setName($entity->getName());
        $product->setMeasure($entity->getMeasure());
        return $product;
    }
}