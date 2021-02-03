<?php

namespace App\Action\Additional;

use App\Entity\Product\Stuff;
use App\Repository\Product\StuffRepository;
use App\Services\Collection\MeasureCollection;
use Doctrine\ORM\EntityManagerInterface;

/** @method Stuff getEntity()() */

/** @property Stuff $entity */
class StuffActions extends Actions
{
    public function __construct(
        EntityManagerInterface $manager, StuffRepository $repository
    )
    {
        parent::__construct($manager, $repository);
    }

    public function getMeasures(): array
    {
        $result = [];
        $measure = $this->entity->getMeasure();
        $result['default'] = $measure->getId();
        $result['measures'] = MeasureCollection::fromEntity($measure);
        return $result;
    }
}