<?php

namespace App\Repository\Alert;

use App\Entity\Alert\Alert;
use App\Entity\Supply\Supply;
use App\Entity\User;
use App\Model\Filters\Alert as Model;
use App\Repository\FindForUser;
use App\Repository\FindTrait;
use App\Repository\Paginable;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\QueryBuilder;

/**
 * @method Alert|null find($id, $lockMode = null, $lockVersion = null)
 * @method Alert|null findOneBy(array $criteria, array $orderBy = null)
 * @method Alert[]    findAll()
 * @method Alert[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AlertRepository extends Paginable implements FindForUser
{
    use FindTrait;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Alert::class);
    }

    public function filter(User $user, Model $alert): QueryBuilder
    {
        $builder = $this->createQueryBuilder('e')
            ->where('e.user = :user_id')
            ->setParameter('user_id', $user->getId());
        if ($alert->getDescription() !== '') {
            $builder->andWhere('lower(e.description) like lower(:description)')
                ->setParameter('description', '%' . $alert->getDescription() . '%');
        }
        if ($alert->getTypes() !== []) {
            $builder->andWhere('e.type in (:types)')
                ->setParameter('types', $alert->getTypes());
        }
        if ($alert->findActive() xor $alert->findInactive()) {
            $builder->andWhere('e.isActive = :status')
                ->setParameter('status', $alert->findActive());
        }
        return $builder;
    }

    public function findForSupply(User $user, Supply $supply): array
    {
        $query = $this->_em->createQuery(
            'SELECT a.id, a.description, t.type from App\Entity\Alert\Alert a
            INNER JOIN a.type as t
            WHERE a.user = :user
            AND a.id NOT IN (
            SELECT a1.id FROM App\Entity\Supply\Alert a0
            INNER JOIN a0.alert a1
            WHERE a0.supply = :supply
            )'
        );
        return $query->setParameter('user', $user->getId())
            ->setParameter('supply', $supply->getId())
            ->getResult();
    }
}
