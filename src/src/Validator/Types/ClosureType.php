<?php


namespace App\Validator\Types;


class ClosureType implements Type
{

    public function check($value): bool
    {
        return is_callable($value);
    }

    public function getType(): string
    {
        return 'closure';
    }
}