<?php

namespace App\Action\Additional;

use App\Entity\Product\Product;
use App\Repository\Product\ProductRepository;
use App\Services\Collection\MeasureCollection;
use Doctrine\ORM\EntityManagerInterface;

/** @method Product getEntity()() */

/** @property Product $entity */
class ProductActions extends Actions
{
    public function __construct(
        EntityManagerInterface $manager, ProductRepository $repository
    )
    {
        parent::__construct($manager, $repository);
    }

    public function getMeasures(): array
    {
        $result = [];
        $measure = $this->entity->getMeasure();
        $result['measures'] = MeasureCollection::fromEntity($measure);
        $result['default'] = $measure->getId();
        return $result;
    }
}