<?php

namespace App\Model\Measures;

use App\Entity\Measure;
use App\Model\Model;

class Edit implements Model
{
    private ?string $name;
    private ?string $shortcut;
    private Measure $entity;
    public function __construct()
    {
        $this->name = null;
        $this->shortcut=null;
    }


    public function getShortcut(): ?string
    {
        return $this->shortcut;
    }


    public function setShortcut(?string $shortcut): void
    {
        $this->shortcut = $shortcut;
    }


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
        $this->entity->setShortcut($this->shortcut);
        return $this->entity;
    }

    public static function fromEntity($entity): self
    {
        $measure = new self();
        $measure->setName($entity->getName());
        $measure->setShortcut($entity->getShortcut());
        return $measure;
    }

    public function setEntity($entity)
    {
        return $this->entity=$entity;
    }
}