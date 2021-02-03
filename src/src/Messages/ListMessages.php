<?php

namespace App\Messages;

class ListMessages
{
    public const CREATED_CORRECTLY = 0;
    public const UPDATE_CORRECT = 1;
    /** @var string[] */
    private static array $messages = [
        'Nowa lista została dodana.',
        'Aktualizacja listy przebiegła poprawnie.'
    ];

    public static function getMessage(int $message): string
    {
        return self::$messages[$message];
    }
}