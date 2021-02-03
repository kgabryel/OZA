<?php

namespace App\Enums;

class ProductPosition extends Enum
{
    public const PRODUCT = 0;
    public const STUFF = 1;
    protected static array $values = [
        'Produkt',
        'Towar'
    ];
}