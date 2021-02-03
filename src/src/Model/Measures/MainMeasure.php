<?php

namespace App\Model\Measures;

use App\Entity\Measure;
use App\Services\Makers\UsersModel;

class MainMeasure implements UsersModel
{
    protected ?string $name;
    protected ?string $shortcut;

    public function __construct()
    {
        $this->name = null;
        $this->shortcut = null;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): void
    {
        $this->name = $name;
    }

    public function getShortcut(): ?string
    {
        return $this->shortcut;
    }

    public function setShortcut(?string $shortcut): void
    {
        $this->shortcut = $shortcut;
    }

    public function getEntity(): Measure
    {
        $measure = new Measure();
        $measure->setName($this->name);
        $measure->setShortcut($this->shortcut);
        return $measure;
    }
}