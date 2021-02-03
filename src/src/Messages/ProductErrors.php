<?php

namespace App\Messages;

class ProductErrors
{
    public const NAME_MISSING = 0;
    public const NAME_TOO_LONG = 1;
    public const NAME_IN_USE = 2;
    public const MEASURE_MISSING = 3;
    public const INVALID_MEASURE = 4;
    public const INVALID_VALUE = 5;
    /** @var string[] */
    private static array $errors = [
        'Nazwa nie została podana.',
        'Nazwa jest zbyt długa. Powinna mieć {{ limit }} znaków lub mniej.',
        'Posiadasz już produkt z nazwą: "{{ value }}".',
        'Jednostka nie została wybrana.',
        'Wybrano błędną jednostkę.',
        'Wprowadzono błędną wartość.'
    ];

    public static function getError(int $error): string
    {
        return self::$errors[$error];
    }
}