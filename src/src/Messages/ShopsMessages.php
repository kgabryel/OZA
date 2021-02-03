<?php

namespace App\Messages;

class ShopsMessages
{
    public const CREATED_CORRECTLY = 0;
    public const DELETE_CORRECT = 1;
    public const DELETE_INCORRECT = 2;
    public const UPDATE_CORRECT = 3;
    /** @var string[] */
    private static array $messages = [
        'Nowy sklep został dodany.',
        'Sklep został usunięty pomyślnie.',
        'Wystąpił błąd podczas usuwania sklepu.',
        'Sklep został zaktualizowany pomyślnie.'
    ];

    public static function getMessage(int $message): string
    {
        return self::$messages[$message];
    }
}