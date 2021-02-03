<?php

namespace App\Action\Additional\Lists\Positions;

use App\Action\Additional\Actions;
use App\Entity\ListInterface;
use App\Entity\PositionInterface;
use App\Repository\FindForUser;
use Doctrine\ORM\EntityManagerInterface;

/** @method PositionInterface getEntity()() */

/** @property PositionInterface $entity */
abstract class PositionsActions extends Actions
{
    protected $entity;
    protected EntityManagerInterface $manager;

    public function __construct(
        FindForUser $positionRepository, EntityManagerInterface $manager
    )
    {
        parent::__construct($manager, $positionRepository);
    }

    public function check(): void
    {
        $this->entity->check();
        $this->manager->persist($this->entity);
        $this->manager->flush();
    }

    public function uncheck(): void
    {
        $this->entity->unCheck();
        $this->manager->persist($this->entity);
        $this->manager->flush();
    }

    public function getList(): ListInterface
    {
        return $this->entity->getList();
    }
}