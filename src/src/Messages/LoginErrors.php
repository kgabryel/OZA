<?php

namespace App\Messages;

class LoginErrors
{
    public const INVALID_CSRF = 0;
    public const REQUIRED_EMAIL = 1;
    public const REQUIRED_PASSWORD = 2;
    public const INVALID_EMAIL_FORMAT = 3;
    public const INVALID_EMAIL = 4;
    public const INVALID_PASSWORD = 5;
    public const FB_ERROR = 6;
    /** @var string[] */
    private static array $errors = [
        'Błąd logowania.',
        'Nie wpisano adresu E-mail.',
        'Nie wpisano hasła.',
        'Adres E-mail ma nieprawidłową postać.',
        'Błędne dane logowania.',
        'Błędne dane logowania.',
        'Wystąpił błąd autoryzacji za pomocą Facebook.'
    ];

    public static function getError(int $error): string
    {
        return self::$errors[$error];
    }
}