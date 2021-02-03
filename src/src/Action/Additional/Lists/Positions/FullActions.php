<?php

namespace App\Action\Additional\Lists\Positions;

use App\Entity\Product\Position;
use App\Repository\Product\PositionRepository;
use App\Services\Collection\AlertCollection;
use App\Services\Presentation\ProductPresentation;
use Doctrine\ORM\EntityManagerInterface;

/** @method Position getEntity()() */

/** @property Position $entity */
class FullActions extends PositionsActions
{
    public function __construct(
        PositionRepository $positionRepository, EntityManagerInterface $manager
    )
    {
        parent::__construct($positionRepository, $manager);
    }

    public function getInfo(): array
    {
        $result = ProductPresentation::fromEntity(
            $this->entity->getProduct() ?? $this->entity->getStuff()
                ->getProduct()
        );
        $result['product'] = [
            'id' => $result['id'],
            'name' => $result['name']
        ];
        unset($result['id'], $result['name']);
        return $result;
    }

    public function getAlerts(): array
    {
        return AlertCollection::fromArray(
            $this->entity->getAlerts()
                ->toArray()
        );
    }
}