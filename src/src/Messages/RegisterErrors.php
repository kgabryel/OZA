<?php

namespace App\Messages;

class RegisterErrors
{
    public const EMPTY_EMAIL = 0;
    public const INVALID_EMAIL_FORMAT = 1;
    public const EMAIL_IN_USE = 2;
    public const EMPTY_PASSWORD = 3;
    public const DIFFERENT_PASSWORDS = 4;
    public const INVALID_VALUE = 5;
    /** @var string[] */
    private static array $errors = [
        'Adres E-mail nie może być pusty.',
        'Błędny format adresu E-mail.',
        'Ten adres E-mail jest już wykorzystywany.',
        'Hasło nie może być puste.',
        'Hasła muszą być takie same.',
        'Wprowadzono błędną wartość.'
    ];

    public static function getError(int $error): string
    {
        return self::$errors[$error];
    }
}