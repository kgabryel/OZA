<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepositoryInterface;

interface FindForUser extends ServiceEntityRepositoryInterface
{
    public function findForUser(User $user): array;

    public function findById($id, User $user);
}