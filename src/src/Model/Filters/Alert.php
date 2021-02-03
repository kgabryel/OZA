<?php

namespace App\Model\Filters;

class Alert
{
    private string $description;
    private array $types;
    private array $statuses;

    public function __construct()
    {
        $this->description = '';
        $this->types = [];
        $this->statuses = [];
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(?string $description): void
    {
        if ($description === null) {
            $description = '';
        }
        $this->description = $description;
    }

    public function getTypes(): array
    {
        return $this->types;
    }

    public function setTypes(array $types): void
    {
        foreach ($types as $type) {
            if (is_numeric($type)) {
                $this->types[] = $type;
            }
        }
    }

    public function getStatuses(): array
    {
        return $this->statuses;
    }

    public function setStatuses(array $statuses): void
    {
        $this->statuses = $statuses;
    }

    public function findActive(): bool
    {
        return in_array(1, $this->statuses, true);
    }

    public function findInactive(): bool
    {
        return in_array(2, $this->statuses, true);
    }
}