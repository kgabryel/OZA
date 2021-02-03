<?php

namespace App\Services\Makers;

use App\Entity\User;
use App\Model\Shopping;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class ShoppingMaker implements MakerInterface
{
    private User $user;
    private EntityManagerInterface $entityManager;
    /** @var Shopping[] */
    private array $positions;

    public function __construct(
        EntityManagerInterface $entityManager, TokenStorageInterface $tokenStorage
    )
    {
        $this->entityManager = $entityManager;
        $this->user = $tokenStorage->getToken()
            ->getUser();
    }

    public function setEntity($positions): self
    {
        $this->positions = $positions['positions'] ?? [];
        return $this;
    }

    public function create(): void
    {
        foreach ($this->positions as $position) {
            $this->entityManager->persist($position->getPosition($this->user));
        }
        $this->entityManager->flush();
    }
}