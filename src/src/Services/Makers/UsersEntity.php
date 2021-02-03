<?php

namespace App\Services\Makers;

use App\Entity\User;

interface UsersEntity
{
    public function getUser(): User;

    public function setUser(User $user): self;
}