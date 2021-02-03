<?php

namespace App\Services\Presentation;

use App\Entity\Product\Position;

class ListPositionPresentation
{
    public static function fromEntity(Position $position):array {
        return [
            'type' => $position->getProduct() !== null ? 'Produkt' : 'Towar',
            'position' => $position->getProduct() !== null ? $position->getProduct()
                ->getId() : $position->getStuff()
                ->getId(),
            'amount' => $position->getMeasureValue(),
            'measure' => $position->getMeasure(),
            'date' => (new \DateTime())->format('Y-m-d')
        ];
    }
}