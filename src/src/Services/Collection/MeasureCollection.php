<?php

namespace App\Services\Collection;

use App\Entity\Measure;

class MeasureCollection
{
    public static function toIndexedArray(array $measures): array
    {
        $result = [];
        foreach ($measures as $measure) {
            $result[$measure->getId()] = "{$measure->getName()} ({$measure->getShortcut()})";
        }
        return $result;
    }

    public static function fromEntity(?Measure $measure): array
    {
        if ($measure === null) {
            return [];
        }
        $result = [];
        if ($measure->getMain() !== null) {
            $measure = $measure->getMain();
        }
        $result[$measure->getId()] = "{$measure->getName()} ({$measure->getShortcut()})";
        foreach ($measure->getMeasures() as $position) {
            $result[$position->getId()] = "{$position->getName()} ({$position->getShortcut()})";
        }
        return $result;
    }
}