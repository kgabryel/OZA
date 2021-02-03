<?php

namespace App\Repository\Product;

use App\Entity\Product\Stuff;
use App\Entity\User;
use App\Model\Filters\Stuff as Model;
use App\Repository\FilterForUser;
use App\Repository\FindForUser;
use App\Repository\Paginable;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\QueryBuilder;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @method Stuff|null find($id, $lockMode = null, $lockVersion = null)
 * @method Stuff|null findOneBy(array $criteria, array $orderBy = null)
 * @method Stuff[]    findAll()
 * @method Stuff[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StuffRepository extends Paginable implements FilterForUser, FindForUser
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Stuff::class);
    }

    public function filter(User $user, Model $stuff): QueryBuilder
    {
        $builder = $this->createQueryBuilder('e')
            ->innerJoin('e.product', 'g')
            ->where('g.user = :user_id')
            ->setParameter('user_id', $user->getId());
        if ($stuff->getName() !== '') {
            $builder->andWhere('lower(e.name) like lower(:name)')
                ->setParameter('name', '%' . $stuff->getName() . '%');
        }
        if ($stuff->getMeasures() !== []) {
            $builder->andWhere('e.measure in (:measures)')
                ->setParameter('measures', $stuff->getMeasures());
        }
        if ($stuff->getProducts() !== []) {
            $builder->andWhere('e.product in (:products)')
                ->setParameter('products', $stuff->getProducts());
        }
        if ($stuff->getProductMeasures() !== []) {
            $builder->andWhere('g.measure in (:productMeasures)')
                ->setParameter('productMeasures', $stuff->getProductMeasures());
        }
        return $builder;
    }

    public function findByName(string $name, User $user, int $limit)
    {
        return $this->createQueryBuilder('s')
            ->select('s.id', 's.name')
            ->innerJoin('s.product', 'p')
            ->where('p.user = :user_id')
            ->andWhere('lower(s.name) like lower(:name)')
            ->setMaxResults($limit)
            ->setParameter('user_id', $user->getId())
            ->setParameter('name', '%' . $name . '%')
            ->getQuery()
            ->getResult();
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

    public function findById($id, User $user)
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

    public function filterForUser(
        string $columnName, string $columnValue, string $userColumn, UserInterface $user, int $id,
        bool $isNumeric = false
    ): array
    {
        $builder = $this->createQueryBuilder('e')
            ->select('e')
            ->innerJoin('e.measure', 'm');
        if ($isNumeric) {
            $builder->where('e.' . $columnName . ' = :value');
        } else {
            $builder->where('lower(e.' . $columnName . ') = lower(:value)');
        }
        return $builder->andWhere('m.' . $userColumn . ' = :user')
            ->andWhere('e.id != :id')
            ->setParameter('id', $id)
            ->setParameter('value', $columnValue)
            ->setParameter('user', $user)
            ->getQuery()
            ->getResult();
    }
}
