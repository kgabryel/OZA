<?php


namespace App\Model;


use App\Entity\Measure;
use App\Entity\Product\Product;
use App\Entity\Shop;
use App\Entity\User;
use App\Entity\Product\Stuff;
use App\Services\PositionFactory\PositionFactory;
use App\Entity\Shopping as Entity;
use DateTime;

class Shopping
{
    private bool $promotion;
    private float $price;
    private float $amount;
    private ?Measure $measure;
    private ?Shop $shop;
    private string $type;
    private ?Product $product;
    private ?Stuff $stuff;
    private DateTime $date;

    public function __construct(array $data, PositionFactory $factory)
    {
        $this->promotion = (bool)($data['promotion'] ?? true);
        $this->amount = (float)($data['amount'] ?? 0);
        $this->price = (float)($data['price'] ?? 0);
        $this->measure = $data['measure'] ?? null;
        $this->shop = $data['shop'] ?? null;
        $this->date = new DateTime($data['date'] ?? null);
        $this->type = in_array(
            $data['type'] ?? 'Produkt',
            [
                'Produkt',
                'Towar'
            ],
            true
        ) ? $data['type'] : 'Produkt';
        $concreteFactory = $factory->get($this->type, (int)($data['position'] ?? 0));
        $this->product = $concreteFactory->getProduct();
        $this->stuff = $concreteFactory->getStuff();
    }

    /**
     * @return DateTime
     */
    public function getDate(): DateTime
    {
        return $this->date;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getProduct(): ?Product
    {
        return $this->product;
    }

    public function getStuff(): ?Stuff
    {
        return $this->stuff;
    }


    public function getMeasure(): ?Measure
    {
        return $this->measure;
    }


    public function getShop(): ?Shop
    {
        return $this->shop;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function getAmount(): float
    {
        return $this->amount;
    }

    public function isPromotion(): bool
    {
        return $this->promotion;
    }

    public function getPosition(User $user): Entity
    {
        $entity = new Entity();
        $entity->setUser($user);
        if ($this->type == 'Produkt') {
            $entity->setProduct($this->product);
        } else {
            $entity->setStuff($this->stuff);
        }
        $entity->setShop($this->shop);
        $entity->setDate($this->date);
        if($this->promotion){
            $entity->withPromotion();
        }
        $entity->setMeasure($this->measure);
        $parsedPrice=$this->price/$this->amount;
        $parsedMeasure=$this->measure;
        if($this->measure->getMain() !==null){
            $parsedPrice*=$this->measure->getConverter();
            $parsedMeasure=$this->measure->getMain();
        }
        $entity->setPrice($parsedPrice);
        $entity->setMeasure($parsedMeasure);
        return $entity;
    }
}