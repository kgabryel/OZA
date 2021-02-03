<?php

namespace App\Services\Lists\Makers;

use App\Entity\QuickList\QuickList;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class QuickMaker implements Maker
{
    private QuickList $list;
    private User $user;
    private EntityManagerInterface $entityManager;

    public function __construct(
        TokenStorageInterface $tokenStorage, EntityManagerInterface $entityManager
    )
    {
        $this->user = $tokenStorage->getToken()
            ->getUser();
        $this->entityManager = $entityManager;
    }

    public function set($quickListModel): self
    {
        $this->list = $quickListModel->getList();
        $this->list->setUser($this->user);
        return $this;
    }

    public function create(): void
    {
        foreach ($this->list->getPositions() as $position) {
            $this->entityManager->persist($position);
        }
        $this->entityManager->persist($this->list);
        $this->entityManager->flush();
    }
}