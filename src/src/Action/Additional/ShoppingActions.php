<?php

namespace App\Action\Additional;

use App\Entity\Shopping;
use App\Repository\ShoppingRepository;
use Doctrine\ORM\EntityManagerInterface;

/** @method Shopping getEntity()() */

/** @property Shopping $entity */
class ShoppingActions extends Actions
{
    public function __construct(
        EntityManagerInterface $manager, ShoppingRepository $repository
    )
    {
        parent::__construct($manager, $repository);
    }
}