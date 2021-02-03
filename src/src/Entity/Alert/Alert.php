<?php

namespace App\Entity\Alert;

use App\Entity\Product\Position;
use App\Entity\Supply\Alert as SupplyAlert;
use App\Entity\User;
use App\Services\Makers\UsersEntity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\Alert\AlertRepository")
 * @ORM\Table(name="alerts")
 */
class Alert implements UsersEntity
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isActive;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="alerts")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Alert\Type", inversedBy="alerts")
     * @ORM\JoinColumn(nullable=false)
     */
    private $type;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Product\Position", mappedBy="alerts")
     */
    private $positions;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Supply\Alert", mappedBy="alert", cascade="all")
     */
    private $supplyAlerts;

    public function __construct()
    {
        $this->positions = new ArrayCollection();
        $this->supplyAlerts = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function isActive(): bool
    {
        return $this->isActive;
    }

    public function activate(): self
    {
        $this->isActive = true;

        return $this;
    }

    public function deactivate(): self
    {
        $this->isActive = false;
        $this->clearPositions();
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

    public function getType(): Type
    {
        return $this->type;
    }

    public function setType(Type $type): self
    {
        $this->type = $type;

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
            $position->addAlert($this);
        }

        return $this;
    }

    public function removePosition(Position $position): self
    {
        if ($this->positions->contains($position)) {
            $this->positions->removeElement($position);
            $position->removeAlert($this);
        }

        return $this;
    }

    public function clearPositions(): self
    {
        /** @var Position $position */
        foreach($this->positions as $position){
            $this->removePosition($position);
        }
        return $this;
    }

    /**
     * @return Collection|SupplyAlert[]
     */
    public function getSupplyAlerts(): Collection
    {
        return $this->supplyAlerts;
    }

    public function addSupplyAlert(SupplyAlert $supplyAlert): self
    {
        if (!$this->supplyAlerts->contains($supplyAlert)) {
            $this->supplyAlerts[] = $supplyAlert;
            $supplyAlert->setAlert($this);
        }

        return $this;
    }

    public function removeSupplyAlert(SupplyAlert $supplyAlert): self
    {
        if ($this->supplyAlerts->contains($supplyAlert)) {
            $this->supplyAlerts->removeElement($supplyAlert);
            // set the owning side to null (unless already changed)
            if ($supplyAlert->getAlert() === $this) {
                $supplyAlert->setAlert(null);
            }
        }

        return $this;
    }
}
