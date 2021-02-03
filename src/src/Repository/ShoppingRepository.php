<?php

namespace App\Repository;

use App\Entity\Shopping;
use App\Entity\User;
use App\Model\Filters\Shopping as Model;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\QueryBuilder;

/**
 * @method Shopping|null find($id, $lockMode = null, $lockVersion = null)
 * @method Shopping|null findOneBy(array $criteria, array $orderBy = null)
 * @method Shopping[]    findAll()
 * @method Shopping[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ShoppingRepository extends Paginable implements FindForUser
{
    use FindTrait;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Shopping::class);
    }

    public function filter(User $user, Model $shopping): QueryBuilder
    {
        $builder = $this->createQueryBuilder('e')
            ->innerJoin('e.measure', 'm')
            ->where('m.user = :user_id')
            ->setParameter('user_id', $user->getId());
        if ($shopping->getDateFrom() !== null) {
            $builder->andWhere('e.date >= :dateFrom')
                ->setParameter('dateFrom', $shopping->getDateFrom());
        }
        if ($shopping->getDateTo() !== null) {
            $builder->andWhere('e.date <= :dateTo')
                ->setParameter('dateTo', $shopping->getDateTo());
        }
        if ($shopping->getShops() !== []) {
            $builder->andWhere('e.shop in (:shops)')
                ->setParameter('shops', $shopping->getShops());
        }
        if ($shopping->getMeasures() !== []) {
            $builder->andWhere('e.measure in (:measures)')
                ->setParameter('measures', $shopping->getMeasures());
        }
        if ($shopping->withPromotion() xor $shopping->withoutPromotion()) {
            $builder->andWhere('e.promotion = :promotion')
                ->setParameter('promotion', $shopping->withPromotion());
        }
        if ($shopping->getProducts() !== []) {
            $builder->andWhere('e.product in (:products)')
                ->setParameter('products', $shopping->getProducts());
        }
        if ($shopping->getStuffs() !== []) {
            $builder->andWhere('e.stuff in (:stuffs)')
                ->setParameter('stuffs', $shopping->getStuffs());
        }
        return $builder;
    }
}
