<?php

namespace App\Entity\Product;

use App\Entity\Alert\Alert;
use App\Entity\Measure;
use App\Entity\PositionInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\Product\PositionRepository")
 * ORM\Table(name="products_lists_positions")
 */
class Position implements PositionInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Product\Product", inversedBy="positions")
     */
    private $product;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Product\Stuff", inversedBy="positions")
     */
    private $stuff;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Measure", inversedBy="listPositions")
     * @ORM\JoinColumn(nullable=false)
     */
    private $measure;

    /**
     * @ORM\Column(type="float")
     */
    private $measureValue;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Alert\Alert", inversedBy="positions")
     */
    private $alerts;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Product\ProductsList", inversedBy="positions")
     * @ORM\JoinColumn(nullable=false)
     */
    private $list;

    /**
     * @ORM\Column(type="boolean")
     */
    private $checked;

    public function __construct()
    {
        $this->alerts = new ArrayCollection();
        $this->checked=false;
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getMeasure(): Measure
    {
        return $this->measure;
    }

    public function setMeasure(Measure $measure): self
    {
        $this->measure = $measure;

        return $this;
    }

    public function getMeasureValue(): ?float
    {
        return $this->measureValue;
    }

    public function setMeasureValue(float $measureValue): self
    {
        $this->measureValue = $measureValue;

        return $this;
    }

    /**
     * @return Collection|Alert[]
     */
    public function getAlerts(): Collection
    {
        return $this->alerts;
    }

    public function addAlert(Alert $alert): self
    {
        if (!$this->alerts->contains($alert)) {
            $this->alerts[] = $alert;
        }

        return $this;
    }

    public function removeAlert(Alert $alert): self
    {
        if ($this->alerts->contains($alert)) {
            $this->alerts->removeElement($alert);
        }

        return $this;
    }

    public function getList(): ProductsList
    {
        return $this->list;
    }

    public function setList(?ProductsList $list): self
    {
        $this->list = $list;

        return $this;
    }

    public function getChecked(): ?bool
    {
        return $this->checked;
    }

    public function setChecked(bool $checked): self
    {
        $this->checked = $checked;

        return $this;
    }

    /** @return Product|Stuff */
    public function getContent()
    {
        if ($this->product !== null) {
            return $this->product;
        }
        return $this->stuff;
    }

    public function isProduct(): bool
    {
        return $this->product === null;
    }

    public function isStuff(): bool
    {
        return $this->stuff === null;
    }

    public function check(): self
    {
        $this->checked = true;
        return $this;
    }
    public function unCheck(): self
    {
        $this->checked = false;
        return $this;
    }
}
