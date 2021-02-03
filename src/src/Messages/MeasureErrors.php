<?php

namespace App\Messages;

class MeasureErrors
{
    public const NAME_MISSING = 0;
    public const SHORTCUT_MISSING = 1;
    public const NAME_TOO_LONG = 2;
    public const SHORTCUT_TOO_LONG = 3;
    public const NAME_IN_USE = 4;
    public const SHORTCUT_IN_USE = 5;
    public const CONVERTER_MISSING = 6;
    public const INVALID_CONVERTER = 7;
    public const MEASURE_MISSING = 8;
    public const INVALID_MEASURE = 9;
    public const INVALID_VALUE = 10;
    /** @var string[] */
    private static array $errors = [
        'Nazwa nie została podana.',
        'Skrót nie został podany.',
        'Nazwa jest zbyt długa. Powinna mieć {{ limit }} znaków lub mniej.',
        'Skrót jest zbyt długi. Powinna mieć {{ limit }} znaków lub mniej.',
        'Posiadasz już jednostkę z nazwą: "{{ value }}".',
        'Posiadasz już jednostkę ze skrótem: "{{ value }}".',
        'Przelicznik nie został podany.',
        'Przelicznik musi być większy niż {{ compared_value }}.',
        'Jednostka główna nie została wybrana.',
        'Wybrano błędną jednostkę.',
        'Wprowadzono błędną wartość.'
    ];

    public static function getError(int $error): string
    {
        return self::$errors[$error];
    }
}