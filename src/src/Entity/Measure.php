<?php

namespace App\Entity;

use App\Entity\Product\Stuff;
use App\Entity\Product\Position;
use App\Entity\Product\Product;
use App\Services\Makers\UsersEntity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MeasureRepository")
 * @ORM\Table(name="measures")
 */
class Measure implements UsersEntity
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=10)
     */
    private $shortcut;

    /**
     * @ORM\ManyToOne(targetEntity="Measure", inversedBy="measures")
     */
    private $main;

    /**
     * @ORM\OneToMany(targetEntity="Measure", mappedBy="main", cascade="all")
     */
    private $measures;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $converter;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="measures")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Product\Product", mappedBy="measure", cascade="all")
     */
    private $products;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Product\Stuff", mappedBy="measure", cascade="all")
     */
    private $stuffs;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Product\Position", mappedBy="measure", cascade="all")
     */
    private $listPositions;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Shopping", mappedBy="measure", cascade="all")
     */
    private $shopping;

    public function __construct()
    {
        $this->measures = new ArrayCollection();
        $this->stuffs = new ArrayCollection();
        $this->products = new ArrayCollection();
        $this->listPositions = new ArrayCollection();
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

    public function getShortcut(): ?string
    {
        return $this->shortcut;
    }

    public function setShortcut(string $shortcut): self
    {
        $this->shortcut = $shortcut;

        return $this;
    }

    public function getMain(): ?self
    {
        return $this->main;
    }

    public function setMain(?self $main): self
    {
        $this->main = $main;

        return $this;
    }

    /**
     * @return Collection|self[]
     */
    public function getMeasures(): Collection
    {
        return $this->measures;
    }

    public function addMeasure(self $measure): self
    {
        if (!$this->measures->contains($measure)) {
            $this->measures[] = $measure;
            $measure->setMain($this);
        }

        return $this;
    }

    public function removeMeasure(self $measure): self
    {
        if ($this->measures->contains($measure)) {
            $this->measures->removeElement($measure);
            // set the owning side to null (unless already changed)
            if ($measure->getMain() === $this) {
                $measure->setMain(null);
            }
        }

        return $this;
    }

    public function getConverter(): ?float
    {
        return $this->converter;
    }

    public function setConverter(?float $converter): self
    {
        $this->converter = $converter;

        return $this;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function setUser(User $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection|Stuff[]
     */
    public function getStuffs(): Collection
    {
        return $this->stuffs;
    }

    public function addStuff(Stuff $stuff): self
    {
        if (!$this->stuffs->contains($stuff)) {
            $this->stuffs[] = $stuff;
            $stuff->setMeasure($this);
        }

        return $this;
    }

    public function removeStuff(Stuff $stuff): self
    {
        if ($this->stuffs->contains($stuff)) {
            $this->stuffs->removeElement($stuff);
            // set the owning side to null (unless already changed)
            if ($stuff->getMeasure() === $this) {
                $stuff->setMeasure(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Product[]
     */
    public function getProducts(): Collection
    {
        return $this->products;
    }

    public function addProduct(Product $product): self
    {
        if (!$this->products->contains($product)) {
            $this->products[] = $product;
            $product->setMeasure($this);
        }

        return $this;
    }

    public function removeProduct(Product $product): self
    {
        if ($this->products->contains($product)) {
            $this->products->removeElement($product);
            // set the owning side to null (unless already changed)
            if ($product->getMeasure() === $this) {
                $product->setMeasure(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Position[]
     */
    public function getListPositions(): Collection
    {
        return $this->listPositions;
    }

    public function addListPosition(Position $listPosition): self
    {
        if (!$this->listPositions->contains($listPosition)) {
            $this->listPositions[] = $listPosition;
            $listPosition->setMeasure($this);
        }

        return $this;
    }

    public function removeListPosition(Position $listPosition): self
    {
        if ($this->listPositions->contains($listPosition)) {
            $this->listPositions->removeElement($listPosition);
            // set the owning side to null (unless already changed)
            if ($listPosition->getMeasure() === $this) {
                $listPosition->setMeasure(null);
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
            $shopping->setMeasure($this);
        }

        return $this;
    }

    public function removeShopping(Shopping $shopping): self
    {
        if ($this->shopping->contains($shopping)) {
            $this->shopping->removeElement($shopping);
            // set the owning side to null (unless already changed)
            if ($shopping->getMeasure() === $this) {
                $shopping->setMeasure(null);
            }
        }

        return $this;
    }

    public function getFull(): string
    {
        return sprintf('%s (%s)', $this->name, $this->shortcut);
    }
}
