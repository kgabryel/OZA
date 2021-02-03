<?php

namespace App\Messages;

class ShopErrors
{
    public const NAME_MISSING = 0;
    public const NAME_TOO_LONG = 1;
    public const SHOP_IN_USE = 2;
    public const INVALID_VALUE = 3;
    /** @var string[] */
    private static array $errors = [
        'Nazwa nie została podana.',
        'Nazwa jest zbyt długa. Powinna mieć {{ limit }} znaków lub mniej.',
        'Posiadasz już sklep z nazwą: "{{ value }}".',
        'Wprowadzono błędną wartość.'
    ];

    public static function getError(int $error): string
    {
        return self::$errors[$error];
    }
}