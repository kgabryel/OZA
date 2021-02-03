<?php

namespace App\Action\Additional\Supply;

use App\Action\Additional\Actions;
use App\Entity\Supply\Supply;
use App\Repository\Supply\SupplyRepository;
use Doctrine\ORM\EntityManagerInterface;

/** @method Supply getEntity()() */

/** @property Supply $entity */
class SupplyActions extends Actions
{
    public function __construct(
        EntityManagerInterface $manager, SupplyRepository $repository
    )
    {
        parent::__construct($manager, $repository);
    }
}