<?php

namespace App\Repository;

use App\Entity\User;

trait FindTrait
{
    public function findForUser(User $user): array
    {
        return $this->findBy(['user' => $user]);
    }

    public function findById($id, User $user)
    {
        return $this->findOneBy(
            [
                'id' => $id,
                'user' => $user
            ]
        );
    }
}