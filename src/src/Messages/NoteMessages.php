<?php

namespace App\Messages;

class NoteMessages
{
    public const CREATED_CORRECTLY = 0;
    public const DELETE_CORRECT = 1;
    public const DELETE_INCORRECT = 2;
    /** @var string[] */
    private static array $messages = [
        'Notatka została utworzona poprawnie',
        'Notatka została usunięta pomyślnie.',
        'Wystąpił błąd podczas usuwania notatki.',
    ];

    public static function getMessage(int $message): string
    {
        return self::$messages[$message];
    }
}