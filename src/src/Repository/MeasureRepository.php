<?php

namespace App\Repository;

use App\Entity\Measure;
use App\Entity\Product\Product;
use App\Entity\User;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\QueryBuilder;
use App\Model\Filters\Measure as Model;

/**
 * @method Measure|null find($id, $lockMode = null, $lockVersion = null)
 * @method Measure|null findOneBy(array $criteria, array $orderBy = null)
 * @method Measure[]    findAll()
 * @method Measure[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MeasureRepository extends Paginable implements FilterForUser, FindForUser
{
    use FilterForUserTrait;
    use FindTrait;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Measure::class);
    }

    public function filter(User $user, Model $measure): QueryBuilder
    {
        $builder = $this->createQueryBuilder('e')
            ->where('e.user = :user_id')
            ->setParameter('user_id', $user->getId());
        if ($measure->getName() !== '') {
            $builder->andWhere('lower(e.name) like lower(:name)')
                ->setParameter('name', '%' . $measure->getName() . '%');
        }
        if ($measure->getShortcut() !== '') {
            $builder->andWhere('lower(e.shortcut) like lower(:shortcut)')
                ->setParameter('shortcut', '%' . $measure->getShortcut() . '%');
        }
        if ($measure->getMeasures() !== []) {
            $builder->andWhere('e.main in (:measures)')
                ->setParameter('measures', $measure->getMeasures());
        }
        if ($measure->findMain() xor $measure->findSub()) {
            if ($measure->findMain()) {
                $builder->andWhere('e.main is null');
            } else {
                $builder->andWhere('e.main is not null');
            }
        }
        return $builder;
    }

    public function findProductByIdAndUser(Product $product, int $id): ?Measure
    {
        $mainMeasure = $this->createQueryBuilder('m')
            ->select('m')
            ->join('m.products', 'p')
            ->where('p.id = :product')
            ->setParameter('product', $product->getId())
            ->getQuery()
            ->getResult();
        if (empty($mainMeasure)) {
            return null;
        }
        $result = $this->createQueryBuilder('m')
            ->select('m')
            ->where('m.id = :id')
            ->orWhere('m.main = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getResult();
        if (empty($result)) {
            return null;
        }
        return $result[0];
    }
}
