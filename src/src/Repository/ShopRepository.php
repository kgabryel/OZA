<?php

namespace App\Repository;

use App\Entity\Shop;
use App\Entity\User;
use App\Services\Paginator;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\QueryBuilder;
use App\Model\Filters\Shop as Model;

/**
 * @method Shop|null find($id, $lockMode = null, $lockVersion = null)
 * @method Shop|null findOneBy(array $criteria, array $orderBy = null)
 * @method Shop[]    findAll()
 * @method Shop[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ShopRepository extends Paginable implements FilterForUser, FindForUser
{
    use FilterForUserTrait;
    use FindTrait;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Shop::class);
    }

    public function filter(User $user, Model $shop): QueryBuilder
    {
        $builder = $this->createQueryBuilder('e')
            ->where('e.user = :user_id')
            ->setParameter('user_id', $user->getId());
        if ($shop->getName() !== '') {
            $builder->andWhere('lower(e.name) like lower(:name)')
                ->setParameter('name', '%' . $shop->getName() . '%');
        }
        if ($shop->getDescription() !== '') {
            $builder->andWhere('lower(e.description) like lower(:description)')
                ->setParameter('description', '%' . $shop->getDescription() . '%');
        }
        return $builder;
    }
}
