<?php

namespace App\Messages;

class SupplyMessages
{
    public const CREATED_CORRECTLY = 0;
    public const DELETE_CORRECT = 1;
    public const DELETE_INCORRECT = 2;
    public const UPDATE_CORRECT = 3;
    public const ALERT_ADDED = 4;
    /** @var string[] */
    private static array $messages = [
        'Nowy zasób został dodany.',
        'Zapas został usunięty pomyślnie.',
        'Wystąpił błąd podczas usuwania zapasu.',
        'Zapas został zaktualizowany pomyślnie.',
        'Powiadomienie zostało dodane poprawnie.'
    ];

    public static function getMessage(int $message): string
    {
        return self::$messages[$message];
    }
}