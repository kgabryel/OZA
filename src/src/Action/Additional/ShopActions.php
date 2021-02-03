<?php

namespace App\Action\Additional;

use App\Entity\Shop;
use App\Repository\ShopRepository;
use Doctrine\ORM\EntityManagerInterface;

/** @method Shop getEntity()() */

/** @property Shop $entity */
class ShopActions extends Actions
{
    public function __construct(
        EntityManagerInterface $manager, ShopRepository $repository
    )
    {
        parent::__construct($manager, $repository);
    }
}