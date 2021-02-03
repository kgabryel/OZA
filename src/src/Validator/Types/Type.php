<?php


namespace App\Validator\Types;


interface Type
{
    public function check($value): bool;

    public function getType():string;
}