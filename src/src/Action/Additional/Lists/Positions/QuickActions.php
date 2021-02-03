<?php

namespace App\Action\Additional\Lists\Positions;

use App\Repository\QuickList\PositionRepository;
use Doctrine\ORM\EntityManagerInterface;

class QuickActions extends PositionsActions
{
    public function __construct(
        PositionRepository $positionRepository, EntityManagerInterface $manager
    )
    {
        parent::__construct($positionRepository, $manager);
    }
}