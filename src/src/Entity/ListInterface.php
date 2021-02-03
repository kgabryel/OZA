<?php


namespace App\Entity;


use Doctrine\Common\Collections\Collection;

interface ListInterface
{
    public function getChecked(): Collection;

    public function getPositions():Collection;
}