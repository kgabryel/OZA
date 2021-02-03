<?php

namespace App\Repository;

use Symfony\Component\Security\Core\User\UserInterface;

interface FilterForUser
{
    public function filterForUser(
        string $columnName, string $columnValue, string $userColumn, UserInterface $user, int $id,
        bool $isNumeric = false
    ): array;
}

