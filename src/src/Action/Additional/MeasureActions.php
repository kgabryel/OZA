<?php

namespace App\Action\Additional;

use App\Entity\Measure;
use App\Repository\MeasureRepository;
use Doctrine\ORM\EntityManagerInterface;

/** @method Measure getEntity()() */

/** @property Measure $entity */
class MeasureActions extends Actions
{
    public function __construct(EntityManagerInterface $manager, MeasureRepository $repository)
    {
        parent::__construct($manager, $repository);
    }
}