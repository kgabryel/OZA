<?php

namespace App\Services\Lists\Makers;

interface Maker
{
    public function set($listModel): self;

    public function create(): void;
}