<?php

namespace App\Services\PositionFactory;

use App\Entity\User;
use App\Repository\Product\StuffRepository;
use App\Repository\Product\ProductRepository;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class PositionFactory
{
    private ProductRepository $productRepository;
    private StuffRepository $stuffRepository;
    private User $user;

    public function __construct(
        StuffRepository $stuffRepository, ProductRepository $productRepository,
        TokenStorageInterface $tokenStorage
    )
    {
        $this->stuffRepository = $stuffRepository;
        $this->productRepository = $productRepository;
        $this->user = $tokenStorage->getToken()
            ->getUser();
    }

    public function get(string $type, int $id): Factory
    {
        if ($type === 'Produkt') {
            return new ProductFactory($this->productRepository, $this->user, $id);
        }
        return new StuffFactory($this->stuffRepository, $this->user, $id);
    }
}