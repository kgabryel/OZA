<?php

namespace App\Entity;

use App\Entity\Product\Product;
use App\Entity\Product\Stuff;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ShoppingRepository")
 * @ORM\Table(name="shopping")
 */
class Shopping
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="date")
     */
    private $date;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="shopping")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Product\Stuff", inversedBy="shopping")
     */
    private $stuff;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Product\Product", inversedBy="shopping")
     */
    private $product;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Shop", inversedBy="shopping")
     * @ORM\JoinColumn(nullable=false)
     */
    private $shop;

    /**
     * @ORM\Column(type="float")
     */
    private $price;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Measure", inversedBy="shopping")
     * @ORM\JoinColumn(nullable=false)
     */
    private $measure;

    /**
     * @ORM\Column(type="boolean")
     */
    private $promotion;

    public function __construct()
    {
        $this->promotion = false;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getProduct(): ?Product
    {
        return $this->product;
    }

    public function setProduct(?Product $product): self
    {
        $this->product = $product;

        return $this;
    }

    public function getStuff(): ?Stuff
    {
        return $this->stuff;
    }

    public function setStuff(?Stuff $stuff): self
    {
        $this->stuff = $stuff;

        return $this;
    }

    public function getShop(): ?Shop
    {
        return $this->shop;
    }

    public function setShop(?Shop $shop): self
    {
        $this->shop = $shop;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getMeasure(): ?Measure
    {
        return $this->measure;
    }

    public function setMeasure(?Measure $measure): self
    {
        $this->measure = $measure;

        return $this;
    }

    public function hasPromotion(): bool
    {
        return $this->promotion;
    }

    public function withoutPromotion(): self
    {
        $this->promotion = false;
        return $this;
    }

    public function withPromotion(): self
    {
        $this->promotion = true;

        return $this;
    }

    public function getPosition()
    {
        if ($this->product !== null) {
            return $this->product;
        }
        return $this->stuff;
    }

    public function isStuff(): bool
    {
        return $this->stuff !== null;
    }

    public function isProduct(): bool
    {
        return $this->product !== null;
    }
}
