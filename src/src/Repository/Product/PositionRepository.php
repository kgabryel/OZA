<?php

namespace App\Repository\Product;

use App\Entity\Product\Position;
use App\Entity\User;
use App\Repository\FindForUser;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Position|null find($id, $lockMode = null, $lockVersion = null)
 * @method Position|null findOneBy(array $criteria, array $orderBy = null)
 * @method Position[]    findAll()
 * @method Position[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PositionRepository extends ServiceEntityRepository implements FindForUser
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Position::class);
    }

    public function findForUser(User $user): array
    {
        return $this->createQueryBuilder('e')
            ->select('e')
            ->innerJoin('e.measure', 'm')
            ->where('m.user = :id')
            ->setParameter('id', $user->getId())
            ->getQuery()
            ->getResult();
    }

    public function findById($id, User $user): ?Position
    {
        return $this->createQueryBuilder('e')
            ->select('e')
            ->innerJoin('e.measure', 'm')
            ->where('m.user = :user')
            ->andWhere('e.id = :id')
            ->setParameter('user', $user->getId())
            ->setParameter('id', $id)
            ->getQuery()
            ->getOneOrNullResult();
    }
}
