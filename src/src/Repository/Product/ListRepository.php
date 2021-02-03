<?php

namespace App\Repository\Product;

use App\Entity\Product\ProductsList;
use App\Repository\FindForUser;
use App\Repository\FindTrait;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method ProductsList|null find($id, $lockMode = null, $lockVersion = null)
 * @method ProductsList|null findOneBy(array $criteria, array $orderBy = null)
 * @method ProductsList[]    findAll()
 * @method ProductsList[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ListRepository extends ServiceEntityRepository implements FindForUser
{
    use FindTrait;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ProductsList::class);
    }
}
