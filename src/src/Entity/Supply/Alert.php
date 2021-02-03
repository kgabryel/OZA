<?php

namespace App\Entity\Supply;

use Doctrine\ORM\Mapping as ORM;
use App\Entity\Alert\Alert as Description;
/**
 * @ORM\Entity(repositoryClass="App\Repository\Supply\AlertRepository")
 * @ORM\Table(name="supply_alerts")
 */
class Alert
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Alert\Alert", inversedBy="supplyAlerts")
     * @ORM\JoinColumn(nullable=false)
     */
    private $alert;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Supply\Supply", inversedBy="alerts")
     * @ORM\JoinColumn(nullable=false)
     */
    private $supply;

    /**
     * @ORM\Column(type="float")
     */
    private $amount;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAlert(): Description
    {
        return $this->alert;
    }

    public function setAlert(Description $alert): self
    {
        $this->alert = $alert;

        return $this;
    }

    public function getSupply(): Supply
    {
        return $this->supply;
    }

    public function setSupply(Supply $supply): self
    {
        $this->supply = $supply;

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
}
