<?php

namespace App\Services;

use App\Entity\Alert\Alert;
use App\Entity\Measure;
use App\Entity\Product\Product;
use App\Entity\Product\ProductsList;
use App\Entity\QuickList\QuickList;
use App\Entity\Shop;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class UserCounts
{
    private EntityManagerInterface $entityManager;
    private User $user;
    private static array $entities = [
        'alerts' => Alert::class,
        'shops' => Shop::class,
        'measures' => Measure::class,
        'quick_lists' => QuickList::class,
        'products' => Product::class,
        'lists' => ProductsList::class
    ];
    private array $menuCounts;

    public function __construct(
        EntityManagerInterface $manager, TokenStorageInterface $tokenStorage
    )
    {
        $this->entityManager = $manager;
        $this->user = $tokenStorage->getToken()
            ->getUser();
        $this->menuCounts = [];
        $this->setSimple();
        $this->setShoppingCounts();
        $this->setStuffCounts();
        $this->setSuppliesCounts();
    }

    private function setSimple(): void
    {
        foreach (self::$entities as $key => $value) {
            $this->menuCounts[$key] = $this->entityManager->createQuery(
                sprintf(
                    '
            SELECT count(e)
            FROM %s e
            WHERE e.user = :user',
                    $value
                )
            )
                                          ->setParameter('user', $this->user->getId())
                                          ->getScalarResult()[0][1];
        }
    }

    private function setStuffCounts(): void
    {
        $this->menuCounts['stuffs'] = $this->entityManager->createQuery(
            'SELECT count(e)
            FROM App\Entity\Product\Stuff e
            join e.measure m
            WHERE m.user = :user'
        )
                                          ->setParameter('user', $this->user->getId())
                                          ->getScalarResult()[0][1];
    }

    private function setShoppingCounts(): void
    {
        $this->menuCounts['shopping'] = $this->entityManager->createQuery(
            'SELECT count(e)
            FROM App\Entity\Shopping e
            join e.measure m
            WHERE m.user = :user'
        )
                                            ->setParameter('user', $this->user->getId())
                                            ->getScalarResult()[0][1];
    }

    private function setSuppliesCounts(): void
    {
        $this->menuCounts['supplies'] = $this->entityManager->createQuery(
            'SELECT count(e)
            FROM App\Entity\Supply\Supply e
            join e.product p
            WHERE p.user = :user'
        )
                                            ->setParameter('user', $this->user->getId())
                                            ->getScalarResult()[0][1];
    }

    public function getActiveAlerts(): array
    {
        return $this->entityManager->createQuery(
            'SELECT e
            FROM App\Entity\Alert\Alert e
            WHERE e.user = :user
            AND e.isActive = :active'
        )
            ->setParameter('user', $this->user->getId())
            ->setParameter('active', true)
            ->getResult();
    }

    public function getMenuCounts(): array
    {
        return $this->menuCounts;
    }
}