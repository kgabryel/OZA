<?php

namespace App\Action\Additional;

use App\Entity\Alert\Alert;
use App\Repository\Alert\AlertRepository;
use Doctrine\ORM\EntityManagerInterface;

/** @method Alert getEntity()() */

/** @property Alert $entity */
class AlertActions extends Actions
{
    public function __construct(
        EntityManagerInterface $manager, AlertRepository $repository
    )
    {
        parent::__construct($manager, $repository);
    }

    public function changeStatus(bool $status): bool
    {
        if ($this->entity->isActive() === $status) {
            return false;
        }
        if ($this->entity->isActive()) {
            $this->entity->deactivate();
        } else {
            $this->entity->activate();
        }
        $this->manager->persist($this->entity);
        $this->manager->flush();
        return true;
    }
}