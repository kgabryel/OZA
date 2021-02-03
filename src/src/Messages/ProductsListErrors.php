<?php

namespace App\Messages;

class ProductsListErrors
{
    public const NAME_TOO_LONG = 0;
    public const MEASURE_MISSING = 1;
    public const AMOUNT_MISSING = 2;
    public const AMOUNT_TOO_SMALL = 3;
    public const INVALID_VALUE = 4;
    /** @var string[] */
    private static array $errors = [
        'Nazwa jest zbyt długa. Powinna mieć {{ limit }} znaków lub mniej.',
        'Jednostka nie została wybrana.',
        'Ilość nie została podana',
        'Ilość musi być większy niż {{ compared_value }}.',
        'Wprowadzono błędną wartość.'
    ];

    public static function getError(int $error): string
    {
        return self::$errors[$error];
    }
}