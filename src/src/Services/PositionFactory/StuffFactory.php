<?php

namespace App\Services\PositionFactory;

use App\Entity\Product\Product;
use App\Entity\Product\Stuff;
use App\Entity\User;
use App\Repository\Product\StuffRepository;

class StuffFactory implements Factory
{
    private StuffRepository $repository;
    private User $user;
    private int $id;

    public function __construct(StuffRepository $repository, User $user, int $id)
    {
        $this->repository = $repository;
        $this->user = $user;
        $this->id = $id;
    }

    public function getStuff(): ?Stuff
    {
        return $this->repository->findById($this->id, $this->user);
    }

    public function getProduct(): ?Product
    {
        return null;
    }
}