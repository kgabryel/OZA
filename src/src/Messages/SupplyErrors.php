<?php

namespace App\Messages;

class SupplyErrors
{
    public const AMOUNT_MISSING = 0;
    public const AMOUNT_TOO_SMALL = 1;
    public const PRODUCT_MISSING = 2;
    public const PRODUCT_IN_USE = 3;
    public const ALERT_MISSING = 4;
    public const ALERT_IN_USE = 5;
    public const AMOUNT_IN_USE = 6;
    public const INVALID_VALUE = 7;
    /** @var string[] */
    private static array $errors = [
        'Ilość nie została podana.',
        'Ilość musi być większa niż {{ compared_value }}.',
        'Produkt nie został wybrany.',
        'Ten produkt jest już używany.',
        'Powiadomienie nie zostało wybrane.',
        'To powiadomienie jest już wykorzystywane.',
        'Do tej wartości już jest przypisane powiadomienie.',
        'Wprowadzono błędną wartość.'
    ];

    public static function getError(int $error): string
    {
        return self::$errors[$error];
    }
}