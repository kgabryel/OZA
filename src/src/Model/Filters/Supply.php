<?php


namespace App\Model\Filters;


class Supply
{
    private array $products;
    private ?float $amountMin;
    private ?float $amountMax;
    private array $measures;
    private array $promotion;
    public function __construct()
    {
        $this->products = [];
        $this->amountMin = null;
        $this->amountMax = null;
        $this->measures = [];
        $this->promotion=[];
    }

    public function getPromotion(): array
    {
        return $this->promotion;
    }

    /**
     * @param array $promotion
     */
    public function setPromotion(array $promotion): void
    {
        foreach ($promotion as $pos) {
            if (is_numeric($pos)) {
                $this->promotion[] = $pos;
            }
        }
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

    public function getAmountMin(): ?float
    {
        return $this->amountMin;
    }

    public function setAmountMin(?float $amountMin): void
    {
        $this->amountMin = $amountMin;
    }

    public function getAmountMax(): ?float
    {
        return $this->amountMax;
    }

    public function setAmountMax(?float $amountMax): void
    {
        $this->amountMax = $amountMax;
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
}