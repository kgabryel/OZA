<?php


namespace App\Validator\Types;


class ClassType implements Type
{
    private string $class;

    public function __construct(string $class)
    {
        $this->class = $class;
    }

    public function check($value): bool
    {
        return $value instanceof $this->class;
    }

    public function getType(): string
    {
        return $this->class;
    }
}