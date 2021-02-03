<?php

namespace App\Services\Collection;

use App\Entity\Product\Product;

class ProductCollection
{
    /**
     * @param Product[] $products
     *
     * @return array
     */
    public static function toIndexedArray(array $products): array
    {
        $result=[];
        foreach($products as $product){
            $result[$product->getId()]= $product->getName();
        }
        return $result;
    }
}