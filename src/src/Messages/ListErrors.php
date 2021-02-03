<?php

namespace App\Messages;

class ListErrors
{
    public const UPDATE_ERROR = 0;
    /** @var string[] */
    private static array $errors = [
        'Wystąpił błąd podczas aktualizacji.'
    ];

    public static function getError(int $error): string
    {
        return self::$errors[$error];
    }
}