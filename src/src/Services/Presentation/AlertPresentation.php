<?php

namespace App\Services\Presentation;

use App\Entity\Alert\Alert;

class AlertPresentation
{
    public static function fromEntity(Alert $alert): array
    {
        $result = [];
        $result['id'] = $alert->getId();
        $result['description'] = $alert->getDescription();
        $result['type'] = $alert->getType()
            ->getType();
        $result['isActive'] = $alert->isActive();
        return $result;
    }
}