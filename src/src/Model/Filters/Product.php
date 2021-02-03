<?php

namespace App\Model\Filters;

class Product
{
    private string $name;
    private array $measures;

    public function __construct()
    {
        $this->name = '';
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
}