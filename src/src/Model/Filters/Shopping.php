<?php


namespace App\Model\Filters;


class Shopping
{
    private ?\DateTime $dateFrom;
    private ?\DateTime $dateTo;
    private array $shops;
    private array $measures;
    private array $promotion;
    private array $products;
    private array $stuffs;

    public function __construct()
    {
        $this->dateFrom = null;
        $this->dateTo = null;
        $this->shops = [];
        $this->measures = [];
        $this->promotion = [];
        $this->products = [];
        $this->stuffs = [];
    }

    public function getDateFrom(): ?string
    {
        if ($this->dateFrom !== null) {
            return $this->dateFrom->format('Y-m-d');
        }
        return $this->dateFrom;
    }


    public function setDateFrom(?string $dateFrom): void
    {
        if (!strtotime($dateFrom)) {
            $dateFrom = null;
        }
        $this->dateFrom = new \DateTime($dateFrom);
    }


    public function getDateTo(): ?string
    {
        if ($this->dateTo !== null) {
            return $this->dateTo->format('Y-m-d');
        }
        return $this->dateTo;
    }


    public function setDateTo(?string $dateTo): void
    {
        if (!strtotime($dateTo)) {
            $dateTo = null;
        }
        $this->dateTo = new \DateTime($dateTo);
    }


    public function getShops(): array
    {
        return $this->shops;
    }


    public function setShops(array $shops): void
    {
        foreach ($shops as $shop) {
            if (is_numeric($shop)) {
                $this->shops[] = $shop;
            }
        }
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


    public function getPromotion(): array
    {
        return $this->promotion;
    }

    public function setPromotion(array $promotion): void
    {
        foreach ($promotion as $value) {
            if (is_numeric($value)) {
                $this->promotion[] = $value;
            }
        }
    }

    public function withPromotion(): bool
    {
        return in_array(1, $this->promotion, true);
    }

    public function withoutPromotion(): bool
    {
        return in_array(2, $this->promotion, true);
    }

    public function setProducts(array $products): void
    {
        foreach ($products as $value) {
            if (is_numeric($value)) {
                $this->products[] = $value;
            }
        }
    }

    public function getProducts(): array
    {
        return $this->products;
    }

    public function setStuffs(array $stuffs): void
    {
        foreach ($stuffs as $value) {
            if (is_numeric($value)) {
                $this->stuffs[] = $value;
            }
        }
    }

    public function getStuffs(): array
    {
        return $this->stuffs;
    }
}