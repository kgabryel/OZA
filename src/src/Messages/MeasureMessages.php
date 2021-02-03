<?php

namespace App\Messages;

class MeasureMessages
{
    public const CREATED_CORRECTLY = 0;
    public const UPDATE_CORRECT = 1;
    public const DELETE_CORRECT = 2;
    public const DELETE_INCORRECT = 3;
    /** @var string[] */
    private static array $messages = [
        'Nowa jednostka miary została dodana.',
        'Jednostka została zaktualizowana pomyślnie.',
        'Jednostka została usunięta pomyślnie.',
        'Wystąpił błąd podczas usuwania jednostki.',
    ];

    public static function getMessage(int $message): string
    {
        return self::$messages[$message];
    }
}