<?php

namespace App\Services\Presentation;

use App\Entity\Product\Product;

class ProductPresentation
{
    public static function fromEntity(Product $product): array
    {
        $result = [];
        $result['name'] = $product->getName();
        $result['id'] = $product->getId();
        $result['stuffs'] = [];
        foreach ($product->getStuffs() as $stuff) {
            $result['stuffs'][] = [
                'id' => $stuff->getId(),
                'name' => $stuff->getName()
            ];
        }
        $result['measure']=$product->getMeasure()->getId();
        return $result;
    }
}