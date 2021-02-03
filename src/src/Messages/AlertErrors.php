<?php

namespace App\Messages;

class AlertErrors
{
    public const INVALID_DESCRIPTION = 0;
    public const INVALID_TYPE = 1;
    public const INVALID_VALUE = 2;
    /** @var string[] */
    private static array $errors = [
        'Treść nie została podana.',
        'Typ nie został wybrany.',
        'Wprowadzono błędną wartość.'
    ];

    public static function getError(int $error): string
    {
        return self::$errors[$error];
    }
}