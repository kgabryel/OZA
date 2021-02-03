<?php

namespace App\Model\Measures;

use App\Entity\Measure;

class SubMeasure extends MainMeasure
{
    private ?Measure $mainMeasure;
    private ?float $converter;

    public function __construct()
    {
        parent::__construct();
        $this->mainMeasure = null;
        $this->converter = null;
    }

    /**
     * @return mixed
     */
    public function getMainMeasure()
    {
        return $this->mainMeasure;
    }

    /**
     * @param mixed $mainMeasure
     */
    public function setMainMeasure($mainMeasure): void
    {
        $this->mainMeasure = $mainMeasure;
    }

    /**
     * @return mixed
     */
    public function getConverter()
    {
        return $this->converter;
    }

    /**
     * @param mixed $converter
     */
    public function setConverter($converter): void
    {
        $this->converter = $converter;
    }

    public function getEntity(): Measure
    {
        $measure = parent::getEntity();
        $measure->setConverter($this->converter);
        $measure->setMain($this->mainMeasure);
        return $measure;
    }
}