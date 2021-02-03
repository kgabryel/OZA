<?php


namespace App\Entity;


interface PositionInterface
{
    public function getList(): ListInterface;

    public function check(): self;

    public function unCheck(): self;

}