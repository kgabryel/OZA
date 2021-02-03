<?php

namespace App\Repository\Product;

use App\Entity\Measure;
use App\Entity\Product\Product;
use App\Entity\User;
use App\Repository\FilterForUser;
use App\Repository\FilterForUserTrait;
use App\Repository\FindForUser;
use App\Repository\FindTrait;
use App\Repository\Paginable;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityNotFoundException;
use Doctrine\ORM\QueryBuilder;
use App\Model\Filters\Product as Model;

/**
 * @method Product|null find($id, $lockMode = null, $lockVersion = null)
 * @method Product|null findOneBy(array $criteria, array $orderBy = null)
 * @method Product[]    findAll()
 * @method Product[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductRepository extends Paginable implements FilterForUser, FindForUser
{
    use FilterForUserTrait;
    use FindTrait;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

    public function filter(User $user, Model $product): QueryBuilder
    {
        $builder = $this->createQueryBuilder('e')
            ->where('e.user = :user_id')
            ->setParameter('user_id', $user->getId());
        if ($product->getName() !== '') {
            $builder->andWhere('lower(e.name) like lower(:name)')
                ->setParameter('name', '%' . $product->getName() . '%');
        }
        if ($product->getMeasures() !== []) {
            $builder->andWhere('e.measure in (:measures)')
                ->setParameter('measures', $product->getMeasures());
        }
        return $builder;
    }

    public function findByName(string $name, User $user, int $limit)
    {
        return $this->createQueryBuilder('p')
            ->select('p.id', 'p.name')
            ->where('p.user = :user_id')
            ->andWhere('lower(p.name) like lower(:name)')
            ->setMaxResults($limit)
            ->setParameter('user_id', $user->getId())
            ->setParameter('name', '%' . $name . '%')
            ->getQuery()
            ->getResult();
    }

    public function findWithoutSupply(User $user): array
    {
        $query = $this->_em->createQuery(
            'SELECT p.id, p.name from App\Entity\Product\Product p
            WHERE p.user = :user
            AND p.id NOT IN (
            SELECT p0.id FROM App\Entity\Supply\Supply s0
            INNER JOIN s0.product p0
            GROUP BY p0.id
            )'
        );
        return $query->setParameter(
            'user',
            $user->getId()
        )
            ->getResult();
    }
}
