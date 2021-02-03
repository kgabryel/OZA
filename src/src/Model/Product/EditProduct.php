<?php

namespace App\Model\Product;

use App\Model\Model;
use App\Services\Makers\UsersEntity;

class EditProduct implements Model
{
    private ?string $name;
    private $entity;
    public function __construct()
    {
        $this->name = null;
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


    public function getEntity()
    {
        $this->entity->setName($this->name);
        return $this->entity;
    }

    public static function fromEntity($entity): self
    {
        $product = new self();
        $product->setName($entity->getName());
        return $product;
    }

    public function setEntity($entity)
    {
        return $this->entity=$entity;
    }
}