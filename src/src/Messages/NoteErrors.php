<?php

namespace App\Messages;

class NoteErrors
{
    public const CONTENT_MISSING = 0;
    public const INVALID_VALUE = 1;
    /** @var string[] */
    private static array $errors = [
        'Treść nie została podana.',
        'Wprowadzono błędną wartość.'
    ];

    public static function getError(int $error): string
    {
        return self::$errors[$error];
    }
}