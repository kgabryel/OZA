<?php

namespace App\Services\PositionFactory;

use App\Entity\Product\Stuff;
use App\Entity\Product\Product;
use App\Entity\User;
use App\Repository\Product\ProductRepository;

class ProductFactory implements Factory
{
    private ProductRepository $repository;
    private User $user;
    private int $id;

    public function __construct(ProductRepository $repository, User $user, int $id)
    {
        $this->repository = $repository;
        $this->user = $user;
        $this->id = $id;
    }

    public function getStuff(): ?Stuff
    {
        return null;
    }

    public function getProduct(): ?Product
    {
        return $this->repository->findOneBy(
            [
                'id' => $this->id,
                'user' => $this->user
            ]
        );
    }
}