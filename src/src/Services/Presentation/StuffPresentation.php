<?php

namespace App\Services\Presentation;

use App\Entity\Product\Stuff;

class StuffPresentation
{
    public static function fromEntity(Stuff $stuff): array
    {
        return [
            'id' => $stuff->getId(),
            'name' => $stuff->getName(),
            'product' => $stuff->getProduct()->getId(),
            'measure' => $stuff->getMeasure()->getId()
        ];
    }
}