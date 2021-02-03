<?php

namespace App\Enums;

class Enum
{
    protected static array $values = [];

    public static function getValue(int $key): string
    {
        return static::$values[$key];
    }
}