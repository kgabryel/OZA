<?php

namespace App\Action\Additional;

use App\Entity\User;
use App\Repository\FindForUser;
use Doctrine\ORM\EntityManagerInterface;

abstract class Actions
{
    protected EntityManagerInterface $manager;
    protected FindForUser $repository;
    protected $entity;

    public function __construct(
        EntityManagerInterface $manager, FindForUser $repository
    )
    {
        $this->manager = $manager;
        $this->repository = $repository;
        $this->entity = null;
    }

    public function find($id, User $user): bool
    {
        $this->entity = $this->repository->findById($id, $user);
        return $this->entity !== null;
    }

    public function getEntity()
    {
        return $this->entity;
    }

    public function delete(): void
    {
        $this->manager->remove($this->entity);
        $this->manager->flush();
    }
}