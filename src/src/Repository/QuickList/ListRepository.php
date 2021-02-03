<?php

namespace App\Repository\QuickList;

use App\Entity\QuickList\QuickList;
use App\Entity\User;
use App\Repository\FindForUser;
use App\Repository\FindTrait;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method QuickList|null find($id, $lockMode = null, $lockVersion = null)
 * @method QuickList|null findOneBy(array $criteria, array $orderBy = null)
 * @method QuickList[]    findAll()
 * @method QuickList[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ListRepository extends ServiceEntityRepository implements FindForUser
{
    use FindTrait;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, QuickList::class);
    }
}
