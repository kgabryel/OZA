<?php

namespace App\Services\Makers;

interface MakerInterface
{
    public function setEntity($model): self;

    public function create(): void;
}