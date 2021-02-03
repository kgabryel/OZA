<?php

namespace App\Services\Makers;

use Doctrine\ORM\EntityManagerInterface;

class SimpleMaker implements MakerInterface
{
    protected $entity;
    protected EntityManagerInterface $entityManager;

    public function __construct(
        EntityManagerInterface $entityManager
    )
    {
        $this->entityManager = $entityManager;
    }

    public function setEntity($model): self
    {
        $this->entity = $model->getEntity();
        return $this;
    }

    public function create(): void
    {
        $this->entityManager->persist($this->entity);
        $this->entityManager->flush();
    }
}