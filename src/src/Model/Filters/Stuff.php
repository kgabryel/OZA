<?php


namespace App\Model\Filters;


class Stuff
{
    private string $name;

    private array $measures;
    private array $products;
    private array $productMeasures;
    public function __construct() {
        $this->name='';
        $this->measures=[];
        $this->products=[];
        $this->productMeasures=[];
    }

    public function getProducts(): array
    {
        return $this->products;
    }

    public function setProducts(array $products): void
    {
        foreach ($products as $product) {
            if (is_numeric($product)) {
                $this->products[] = $product;
            }
        }
    }


    public function getName(): string
    {
        return $this->name;
    }


    public function setName(?string $name): void
    {
        if($name === null){
            $name='';
        }
        $this->name = $name;
    }

    public function getMeasures(): array
    {
        return $this->measures;
    }

    public function setMeasures(array $measures): void
    {
        foreach ($measures as $measure) {
            if (is_numeric($measure)) {
                $this->measures[] = $measure;
            }
        }
    }
    public function getProductMeasures(): array
    {
        return $this->productMeasures;
    }

    public function setProductMeasures(array $measures): void
    {
        foreach ($measures as $measure) {
            if (is_numeric($measure)) {
                $this->productMeasures[] = $measure;
            }
        }
    }

}