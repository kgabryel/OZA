<?php

namespace App\Entity\Supply;

use App\Entity\Measure;
use App\Entity\Product\Product;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\Supply\SupplyRepository")
 * @ORM\Table(name="supplies")
 */
class Supply
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Product\Product", inversedBy="supplies")
     * @ORM\JoinColumn(nullable=false)
     */
    private $product;

    /**
     * @ORM\Column(type="float")
     */
    private $amount;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Supply\Alert", mappedBy="supply", cascade="all")
     * @ORM\OrderBy({"amount" = "ASC"})
     */
    private $alerts;

    public function __construct()
    {
        $this->alerts = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getAmount(): ?float
    {
        return $this->amount;
    }

    public function setAmount(float $amount): self
    {
        $this->amount = $amount;

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
            $alert->setSupply($this);
        }

        return $this;
    }

    public function removeAlert(Alert $alert): self
    {
        if ($this->alerts->contains($alert)) {
            $this->alerts->removeElement($alert);
            // set the owning side to null (unless already changed)
            if ($alert->getSupply() === $this) {
                $alert->setSupply(null);
            }
        }

        return $this;
    }

    public function getBefore($alert): ?Alert
    {
        $result = array_search(
            $alert,
            $this->getAlerts()
                ->toArray(),
            true
        );
        if ($result === false || $result === 0) {
            return null;
        }
        return $this->getAlerts()
                   ->toArray()[$result - 1];
    }

    public function getActive(): Collection
    {
        return $this->getAlerts()->filter(function(Alert $alert){
            return $alert->getAlert()->isActive();
        });
    }
}
