<?php

namespace App\Services\Collection;

use App\Entity\Shop;

class ShopCollection
{
    /**
     * @param Shop[] $shops
     *
     * @return array
     */
    public static function toIndexedArray(array $shops): array
    {
        $result = [];
        foreach ($shops as $shop) {
            $result[$shop->getId()] = $shop->getName();
        }
        return $result;
    }
}