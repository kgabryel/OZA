<?php

namespace App\Messages;

class ShoppingErrors
{
    public const SHOP_MISSING = 0;
    public const PRICE_MISSING = 1;
    public const PRICE_TOO_SMALL = 2;
    public const AMOUNT_MISSING = 3;
    public const AMOUNT_TOO_SMALL = 4;
    public const MEASURE_MISSING = 4;
    public const INVALID_VALUE = 6;
    /** @var string[] */
    private static array $errors = [
        'Sklep nie został wybrany.',
        'Cena nie została podana',
        'Cena musi być większy niż {{ compared_value }}.',
        'Ilość nie została podana',
        'Ilość musi być większy niż {{ compared_value }}.',
        'Jednostka nie została wybrana.',
        'Wprowadzono błędną wartość.'
    ];

    public static function getError(int $error): string
    {
        return self::$errors[$error];
    }
}