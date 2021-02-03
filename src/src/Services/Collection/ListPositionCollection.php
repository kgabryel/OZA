<?php

namespace App\Services\Collection;

use App\Entity\QuickList\Position;
use Doctrine\Common\Collections\ArrayCollection;

class ListPositionCollection
{
    /**
     * @param ArrayCollection<string> $names
     *
     * @return array
     */
    public static function asPositionList(ArrayCollection $names): array
    {
        $result = [];
        foreach ($names as $name) {
            $result[] = (new Position())->setContent($name);
        }
        return $result;
    }

    /**
     * @param Position[] $positions
     *
     * @return array
     */
    public static function fromArray(array $positions): array
    {
        $result = [];
        foreach ($positions as $position) {
            $result[] = $position->getContent();
        }
        return $result;
    }
}