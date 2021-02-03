<?php

namespace App\Services\Lists\Makers;

use App\Entity\Product\Position;
use App\Entity\Product\ProductsList;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class FullMaker implements Maker
{
    protected User $user;
    protected EntityManagerInterface $entityManager;
    private ?string $name;
    /** @var Position[] */
    private array $positions;

    public function __construct(
        EntityManagerInterface $entityManager, TokenStorageInterface $tokenStorage
    )
    {
        $this->user = $tokenStorage->getToken()
            ->getUser();
        $this->entityManager = $entityManager;
    }

    public function create(): void
    {
        $list = new ProductsList();
        $list->setUser($this->user);
        $list->setName($this->name);
        foreach ($this->positions as $position) {
            $p = new Position();
            $p->setMeasureValue($position->getAmount());
            $p->setMeasure($position->getMeasure());
            if ($position->getType() === 'Produkt') {
                $p->setProduct($position->getProduct());
            } else {
                $p->setStuff($position->getStuff());
            }
            $list->addPosition($p);
            foreach ($position->getAlerts() as $alert) {
                $p->addAlert($alert);
                $this->entityManager->persist($alert);
            }
            $this->entityManager->persist($p);
        }
        $this->entityManager->persist($list);
        $this->entityManager->flush();
    }

    public function set($data): self
    {
        $this->name = $data['name'];
        $this->positions = $data['positions'];
        return $this;
    }
}