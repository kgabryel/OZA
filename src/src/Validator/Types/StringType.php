<?php


namespace App\Validator\Types;


class StringType implements Type
{

    public function check($value): bool
    {
        return is_string($value);
    }

    public function getType(): string
    {
        return 'string';
    }
}