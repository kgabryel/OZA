<?php

namespace App\Entity\Product;

use App\Entity\Measure;
use App\Entity\Shopping;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\Product\StuffRepository")
 * @ORM\Table(name="stuffs")
 */
class Stuff
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Product\Product", inversedBy="stuffs")
     * @ORM\JoinColumn(nullable=false)
     */
    private $product;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Measure", inversedBy="stuffs")
     * @ORM\JoinColumn(nullable=false)
     */
    private $measure;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Product\Position", mappedBy="stuff", cascade="all")
     */
    private $positions;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Shopping", mappedBy="stuff", cascade="all")
     * @ORM\OrderBy({"date" = "DESC"})
     */
    private $shopping;

    public function __construct()
    {
        $this->positions = new ArrayCollection();
        $this->shopping = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getProduct(): Product
    {
        return $this->product;
    }

    public function setProduct(Product $product): self
    {
        $this->product = $product;

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

    /**
     * @return Collection|Position[]
     */
    public function getPositions(): Collection
    {
        return $this->positions;
    }

    public function addPosition(Position $position): self
    {
        if (!$this->positions->contains($position)) {
            $this->positions[] = $position;
            $position->setStuff($this);
        }

        return $this;
    }

    public function removePosition(Position $position): self
    {
        if ($this->positions->contains($position)) {
            $this->positions->removeElement($position);
            // set the owning side to null (unless already changed)
            if ($position->getStuff() === $this) {
                $position->setStuff(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Shopping[]
     */
    public function getShopping(): Collection
    {
        return $this->shopping;
    }

    public function addShopping(Shopping $shopping): self
    {
        if (!$this->shopping->contains($shopping)) {
            $this->shopping[] = $shopping;
            $shopping->setStuff($this);
        }

        return $this;
    }

    public function removeShopping(Shopping $shopping): self
    {
        if ($this->shopping->contains($shopping)) {
            $this->shopping->removeElement($shopping);
            // set the owning side to null (unless already changed)
            if ($shopping->getStuff() === $this) {
                $shopping->setStuff(null);
            }
        }

        return $this;
    }
}
