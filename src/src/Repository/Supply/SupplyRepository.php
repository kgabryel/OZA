<?php

namespace App\Repository\Supply;

use App\Entity\Supply\Supply;
use App\Entity\User;
use App\Model\Filters\Supply as Model;
use App\Repository\FindForUser;
use App\Repository\Paginable;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\QueryBuilder;

/**
 * @method Supply|null find($id, $lockMode = null, $lockVersion = null)
 * @method Supply|null findOneBy(array $criteria, array $orderBy = null)
 * @method Supply[]    findAll()
 * @method Supply[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SupplyRepository extends Paginable implements FindForUser
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Supply::class);
    }

    public function filter(User $user, Model $supply): QueryBuilder
    {
        $builder = $this->createQueryBuilder('e')
            ->innerJoin('e.product', 'p')
            ->where('p.user = :user_id')
            ->setParameter('user_id', $user->getId());
        if ($supply->getAmountMin() !== null) {
            $builder->andWhere('e.amount >= :amountMin')
                ->setParameter('amountMin', $supply->getAmountMin());
        }
        if ($supply->getAmountMax() !== null) {
            $builder->andWhere('e.amount >= :amountMax')
                ->setParameter('amountMax', $supply->getAmountMax());
        }
        if ($supply->getProducts() !== []) {
            $builder->andWhere('e.product in (:products)')
                ->setParameter('products', $supply->getProducts());
        }
        if ($supply->getMeasures() !== []) {
            $builder->andWhere('p.measure in (:measures)')
                ->setParameter('measures', $supply->getMeasures());
        }
        return $builder;
    }

    public function findById($id, User $user)
    {
        return $this->createQueryBuilder('s')
            ->innerJoin('s.product', 'p')
            ->where('p.user = :user_id')
            ->andWhere('s.id = :id')
            ->setParameter('id', $id)
            ->setParameter('user_id', $user->getId())
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function findForUser(User $user): array
    {
        return $this->createQueryBuilder('s')
            ->innerJoin('s.product', 'p')
            ->where('p.user = :user_id')
            ->setParameter('user_id', $user->getId())
            ->getQuery()
            ->getResult();
    }
}
