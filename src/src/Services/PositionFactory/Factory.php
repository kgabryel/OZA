<?php

namespace App\Services\PositionFactory;

use App\Entity\Product\Product;
use App\Entity\Product\Stuff;

interface Factory
{
    public function getStuff(): ?Stuff;

    public function getProduct(): ?Product;
}