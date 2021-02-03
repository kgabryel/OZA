<?php

namespace App\Services\Collection;

use App\Entity\Alert\Type;

class AlertTypeCollection
{
    /**
     * @param Type[] $types
     *
     * @return array
     */
    public static function toIndexedArray(array $types): array
    {

        $result = [];
        foreach ($types as $type){
            $result[$type->getId()]= $type->getName();
        }
        return $result;
    }
}