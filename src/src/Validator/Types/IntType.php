<?php


namespace App\Validator\Types;


class IntType implements Type
{

    public function check($value): bool
    {
        return is_int($value);
    }

    public function getType(): string
    {
        return 'int';
    }
}