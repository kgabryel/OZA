<?php


namespace App\Validator\Types;


class BoolType implements Type
{

    public function check($value): bool
    {
        return is_bool($value);
    }

    public function getType(): string
    {
        return 'bool';
    }
}