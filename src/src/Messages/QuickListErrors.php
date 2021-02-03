<?php

namespace App\Messages;

class QuickListErrors
{
    public const INVALID_NAME = 0;
    public const INVALID_POSITION = 1;
    public const INVALID_VALUE = 2;
    /** @var string[] */
    private static array $errors = [
        'Nazwa jest zbyt długa. Powinna mieć {{ limit }} znaków lub mniej.',
        'Nazwa jest zbyt długa. Powinna mieć {{ limit }} znaków lub mniej.',
        'Wprowadzono błędną wartość.'
    ];

    public static function getError(int $error): string
    {
        return self::$errors[$error];
    }
}