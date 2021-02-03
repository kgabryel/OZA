<?php

namespace App\Model;

use App\Entity\Shop as Entity;
use Symfony\Component\DependencyInjection\Tests\Compiler\E;


class Shop implements Model
{
    private ?string $name;
    private ?string $description;
    private Entity $shop;
    public function __construct()
    {
        $this->name = null;
        $this->description = null;
        $this->shop=new Entity();
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string|null $name
     */
    public function setName(?string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param string|null $description
     */
    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }

    public function getEntity(): Entity
    {
        $this->shop->setName($this->name);
        $this->shop->setDescription($this->description);
        return $this->shop;
    }

    public static function fromEntity(Entity $entity): self
    {
        $shop = new Shop();
        $shop->setName($entity->getName());
        $shop->setDescription($entity->getDescription());
        return $shop;
    }

    public function setEntity($entity)
    {
        $this->shop=$entity;
        return $this;
    }
}