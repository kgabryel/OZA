<?php

namespace App\Services\Makers;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class AssignedMaker implements MakerInterface
{
    protected UsersEntity $entity;
    protected User $user;
    protected EntityManagerInterface $entityManager;

    public function __construct(
        EntityManagerInterface $entityManager, TokenStorageInterface $tokenStorage
    )
    {
        $this->user = $tokenStorage->getToken()
            ->getUser();
        $this->entityManager = $entityManager;
    }

    public function setEntity($model): self
    {
        $this->entity = $model->getEntity();
        $this->entity->setUser($this->user);
        return $this;
    }

    public function create(): void
    {
        $this->entityManager->persist($this->entity);
        $this->entityManager->flush();
    }
}