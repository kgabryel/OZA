<?php

namespace App\Model\Filters;

class Measure
{
    private string $name;
    private string $shortcut;
    private array $types;
    private array $measures;

    public function __construct()
    {
        $this->name = '';
        $this->shortcut = '';
        $this->types = [];
        $this->measures = [];
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(?string $name): void
    {
        if ($name === null) {
            $name = '';
        }
        $this->name = $name;
    }

    public function getShortcut(): string
    {
        return $this->shortcut;
    }

    public function setShortcut(?string $shortcut): void
    {
        if ($shortcut === null) {
            $shortcut = '';
        }
        $this->shortcut = $shortcut;
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

    public function getMeasures(): array
    {
        return $this->measures;
    }

    public function setMeasures(array $measures): void
    {
        foreach ($measures as $measure) {
            if (is_numeric($measure)) {
                $this->measures[] = $measure;
            }
        }
    }

    public function findMain(): bool
    {
        return in_array(1, $this->types, true);
    }

    public function findSub(): bool
    {
        return in_array(2, $this->types, true);
    }
}