<?php

namespace App\Entity\Product;

use App\Entity\Measure;
use App\Entity\Shopping;
use App\Entity\Supply\Supply;
use App\Entity\User;
use App\Services\Collection\MeasureCollection;
use App\Services\Makers\UsersEntity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\Product\ProductRepository")
 * @ORM\Table(name="products")
 */
class Product implements UsersEntity
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
     * @ORM\ManyToOne(targetEntity="App\Entity\Measure", inversedBy="products")
     * @ORM\JoinColumn(nullable=false)
     */
    private $measure;
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="products")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;
    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Product\Stuff", mappedBy="product", cascade="all")
     */
    private $stuffs;
    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Product\Position", mappedBy="product", cascade="all")
     */
    private $positions;
    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Shopping", mappedBy="product", cascade="all")
     * @ORM\OrderBy({"date" = "DESC"})
     */
    private $shopping;
    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Supply\Supply", mappedBy="product", cascade="all")
     */
    private $supplies;

    public function __construct()
    {
        $this->stuffs = new ArrayCollection();
        $this->positions = new ArrayCollection();
        $this->shopping = new ArrayCollection();
        $this->supplies = new ArrayCollection();
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

    public function getMeasure(): Measure
    {
        return $this->measure;
    }

    public function setMeasure(Measure $measure): self
    {
        $this->measure = $measure;
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
            $stuff->setProduct($this);
        }
        return $this;
    }

    public function removeStuff(Stuff $stuff): self
    {
        if ($this->stuffs->contains($stuff)) {
            $this->stuffs->removeElement($stuff);
            // set the owning side to null (unless already changed)
            if ($stuff->getProduct() === $this) {
                $stuff->setProduct(null);
            }
        }
        return $this;
    }

    /**
     * @return Collection|Position[]
     */
    public function getListPositions(): Collection
    {
        return $this->positions;
    }

    public function addListPosition(Position $position): self
    {
        if (!$this->positions->contains($position)) {
            $this->positions[] = $position;
            $position->setProduct($this);
        }
        return $this;
    }

    public function removeListPosition(Position $position): self
    {
        if ($this->positions->contains($position)) {
            $this->positions->removeElement($position);
            // set the owning side to null (unless already changed)
            if ($position->getProduct() === $this) {
                $position->setProduct(null);
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
            $shopping->setProduct($this);
        }
        return $this;
    }

    public function removeShopping(Shopping $shopping): self
    {
        if ($this->shopping->contains($shopping)) {
            $this->shopping->removeElement($shopping);
            // set the owning side to null (unless already changed)
            if ($shopping->getProduct() === $this) {
                $shopping->setProduct(null);
            }
        }
        return $this;
    }

    /**
     * @return Collection|Supply[]
     */
    public function getSupplies(): Collection
    {
        return $this->supplies;
    }

    public function addSupply(Supply $supply): self
    {
        if (!$this->supplies->contains($supply)) {
            $this->supplies[] = $supply;
            $supply->setProduct($this);
        }
        return $this;
    }

    public function removeSupply(Supply $supply): self
    {
        if ($this->supplies->contains($supply)) {
            $this->supplies->removeElement($supply);
            // set the owning side to null (unless already changed)
            if ($supply->getProduct() === $this) {
                $supply->setProduct(null);
            }
        }
        return $this;
    }

    public function getMeasures(): array
    {
        return MeasureCollection::fromEntity($this->measure);
    }
}
