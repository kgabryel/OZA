<?php

namespace App\Entity;

use App\Services\Makers\UsersEntity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ShopRepository")
 * @ORM\Table(name="shops")
 */
class Shop implements UsersEntity
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=40)
     */
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="shops")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Shopping", mappedBy="shop", cascade="all")
     */
    private $shopping;

    public function __construct()
    {
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

    public function getUser(): User
    {
        return $this->user;
    }

    public function setUser(User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

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
            $shopping->setShop($this);
        }

        return $this;
    }

    public function removeShopping(Shopping $shopping): self
    {
        if ($this->shopping->contains($shopping)) {
            $this->shopping->removeElement($shopping);
            // set the owning side to null (unless already changed)
            if ($shopping->getShop() === $this) {
                $shopping->setShop(null);
            }
        }

        return $this;
    }

}
