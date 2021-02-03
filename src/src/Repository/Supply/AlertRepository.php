<?php

namespace App\Repository\Supply;

use App\Entity\Supply\Alert;
use App\Entity\Supply\Supply;
use App\Entity\User;
use App\Repository\FindForUser;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Alert|null find($id, $lockMode = null, $lockVersion = null)
 * @method Alert|null findOneBy(array $criteria, array $orderBy = null)
 * @method Alert[]    findAll()
 * @method Alert[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AlertRepository extends ServiceEntityRepository implements FindForUser
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Alert::class);
    }

    public function findForUser(User $user): array
    {
        return $this->createQueryBuilder('e')
            ->select('e')
            ->innerJoin('e.alert', 'a')
            ->where('a.user = :id')
            ->setParameter('id', $user->getId())
            ->getQuery()
            ->getResult();
    }

    public function findById($id, User $user): ?self
    {
        return $this->createQueryBuilder('e')
            ->select('e')
            ->innerJoin('e.alert', 'a')
            ->where('a.user = :user')
            ->andWhere('e.id = :id')
            ->setParameter('user', $user->getId())
            ->setParameter('id', $id)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function findAlertToActivate(float $amount, Supply $supply): ?Alert
    {
        return $this->createQueryBuilder('e')
            ->select('e')
            ->innerJoin('e.supply', 's')
            ->where('e.amount >= :amount')
            ->andWhere('e.supply = :supply')
            ->andWhere('e.amount <= s.amount')
            ->setParameter('amount', $amount)
            ->setParameter('supply', $supply->getId())
            ->orderBy('e.amount', 'ASC')
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
    }

}
