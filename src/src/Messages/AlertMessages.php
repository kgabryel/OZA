<?php

namespace App\Messages;

class AlertMessages
{
    public const CREATED_CORRECTLY = 0;
    public const DELETE_CORRECT = 1;
    public const DELETE_INCORRECT = 2;
    public const UPDATE_CORRECT = 3;
    /** @var string[] */
    private static array $messages = [
        'Nowe powiadomienie zostało dodane.',
        'Powiadomienie zostało usunięte pomyślnie.',
        'Wystąpił błąd podczas usuwania powiadomienia.',
        'Powiadomienia zostało zaktualizowane pomyślnie.'
    ];

    public static function getMessage(int $message): string
    {
        return self::$messages[$message];
    }
}