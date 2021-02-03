<?php

namespace App\Model;


use App\Entity\Alert\Alert as Entity;
use App\Entity\Alert\Type;
use App\Services\Makers\UsersEntity;
use App\Services\Makers\UsersModel;

class Alert implements UsersModel, Model
{
    private ?string $description;
    private ?Type $type;
    private bool $active;
    private Entity $alert;

    public function __construct()
    {
        $this->description = null;
        $this->type = null;
        $this->active = false;
        $this->alert = new Entity();
    }

    public function setEntity($alert): self
    {
        $this->alert = $alert;
        return $this;
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

    /**
     * @return Type|null
     */
    public function getType(): ?Type
    {
        return $this->type;
    }

    /**
     * @param Type|null $type
     */
    public function setType(?Type $type): void
    {
        $this->type = $type;
    }

    /**
     * @return bool
     */
    public function isActive(): bool
    {
        return $this->active;
    }

    public function activate(): self
    {
        $this->active = true;
        return $this;
    }

    public function deactivate(): self
    {
        $this->active = false;
        return $this;
    }

    /**
     * @param bool $active
     */
    public function setActive(bool $active): void
    {
        $this->active = $active;
    }

    public function getEntity(): UsersEntity
    {
        $this->alert->setDescription($this->description);
        $this->alert->setType($this->type);
        if ($this->active) {
            $this->alert->activate();
        } else {
            $this->alert->deactivate();
        }
        return $this->alert;
    }

    public static function fromEntity(Entity $entity): self
    {
        $alert = new self();
        $alert->setDescription($entity->getDescription());
        if ($entity->isActive()) {
            $alert->activate();
        }
        $alert->setType($entity->getType());
        return $alert;
    }
}