<?php

namespace App\Services\Presentation;

use App\Entity\Measure;

class MeasurePresentation
{
    public static function fromEntity(Measure $measure): array
    {
        if ($measure->getMain() !== null) {
            $measure = $measure->getMain();
        }
        $result = [];
        $result['id'] = $measure->getId();
        $result['name'] = $measure->getName();
        $result['shortcut'] = $measure->getShortcut();
        $result['subMeasures'] = [];
        foreach ($measure->getMeasures() as $subMeasure) {
            $result['subMeasures'][] = [
                'id' => $subMeasure->getId(),
                'name' => $subMeasure->getName(),
                'shortcut' => $subMeasure->getShortcut(),
                'converter' => $subMeasure->getConverter()
            ];
        }
        return $result;
    }
}