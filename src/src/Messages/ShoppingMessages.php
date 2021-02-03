<?php

namespace App\Messages;

class ShoppingMessages
{
    public const CREATED_CORRECTLY = 0;
    public const DELETE_CORRECT = 1;
    public const DELETE_INCORRECT = 2;
    /** @var string[] */
    private static array $messages = [
        'Nowy zakup został dodany.',
        'Zakup został usunięty pomyślnie.',
        'Wystąpił błąd podczas usuwania zakupu.'
    ];

    public static function getMessage(int $message): string
    {
        return self::$messages[$message];
    }
}