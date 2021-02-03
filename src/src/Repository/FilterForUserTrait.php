<?php

namespace App\Repository;

use Symfony\Component\Security\Core\User\UserInterface;

trait FilterForUserTrait
{
    public function filterForUser(
        string $columnName, string $columnValue, string $userColumn, UserInterface $user, int $id,
        bool $isNumeric = false
    ): array
    {
        $builder = $this->createQueryBuilder('e')
            ->select('e');
        if ($isNumeric) {
            $builder->where('e.' . $columnName . ' = :value');
        } else {
            $builder->where('lower(e.' . $columnName . ') = lower(:value)');
        }
        return $builder->andWhere('e.' . $userColumn . ' = :user')
            ->andWhere('e.id != :id')
            ->setParameter('id', $id)
            ->setParameter('value', $columnValue)
            ->setParameter('user', $user)
            ->getQuery()
            ->getResult();
    }
}