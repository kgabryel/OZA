<?php

namespace App\Messages;

class StuffErrors
{
    public const NAME_MISSING = 0;
    public const NAME_TOO_LONG = 1;
    public const NAME_IN_USE = 2;
    public const PRODUCT_MISSING = 3;
    public const MEASURE_MISSING = 4;
    public const INVALID_VALUE = 5;
    public const INVALID_MEASURE = 6;
    /** @var string[] */
    private static array $errors = [
        'Nazwa nie została podana.',
        'Nazwa jest zbyt długa. Powinna mieć {{ limit }} znaków lub mniej.',
        'Posiadasz już towar z nazwą: "{{ value }}".',
        'Produkt nie został wybrany.',
        'Jednostka nie została wybrana.',
        'Wprowadzono błędną wartość.',
        'Wybrana jednostka nie jest poprawna.'
    ];

    public static function getError(int $error): string
    {
        return self::$errors[$error];
    }
}