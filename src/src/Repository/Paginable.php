<?php

namespace App\Repository;

use App\Services\Paginator;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;

abstract class Paginable extends ServiceEntityRepository
{
    public function paginate(QueryBuilder $builder, int $page, int $limit = 10): Paginator
    {
        $count = $builder->select('count(e.id)')
                     ->getQuery()
                     ->getSingleResult()[1];
        $builder->select('e');
        return new Paginator($count, $builder, $page, $limit);
    }
}