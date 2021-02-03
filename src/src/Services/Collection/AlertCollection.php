<?php

namespace App\Services\Collection;

use App\Entity\Alert\Alert;
use App\Entity\User;
use App\Services\Presentation\AlertPresentation;

class AlertCollection
{
    /**
     *
     * @param Alert[] $alerts
     *
     * @return array
     */
    public static function fromArray(array $alerts): array
    {
        $result = [];
        foreach ($alerts as $alert) {
            $result[] = AlertPresentation::fromEntity($alert);
        }
        return $result;
    }

    /**
     * @param Alert[] $alerts
     * @param User $user
     *
     * @return int[]
     */
    public static function toPositionAlerts(array $alerts, User $user): array
    {
        $result = [];
        foreach ($alerts as $alert) {
            if ($alert->getUser() !== $user || $alert->isActive()) {
                continue;
            }
            $result[] = $alert->getId();
        }
        return array_unique($result);
    }
}