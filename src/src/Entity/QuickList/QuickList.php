<?php

namespace App\Entity\QuickList;

use App\Entity\ListInterface;
use App\Entity\User;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\QuickList\ListRepository")
 * @ORM\Table(name="quick_lists")
 */
class QuickList implements ListInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;
    /**
     * @ORM\Column(type="string", length=50)
     */
    private $name;
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="quickLists")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;
    /**
     * @ORM\OneToMany(targetEntity="App\Entity\QuickList\Position", mappedBy="list", cascade="all")
     */
    private $positions;
    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    public function __construct()
    {
        $this->createdAt = new \DateTime();
        $this->positions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        if ($name === null) {
            $name = '';
        }
        $this->name = $name;
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

    /**
     * @return Collection|Position[]
     */
    public function getPositions(): Collection
    {
        return $this->positions;
    }

    public function addPositions(ArrayCollection $positions): self
    {
        foreach ($positions as $position) {
            $this->addPosition($position);
        }
        return $this;
    }

    public function addPosition(Position $position): self
    {
        if (!$this->positions->contains($position)) {
            $this->positions[] = $position;
            $position->setList($this);
        }
        return $this;
    }

    public function setPositions(ArrayCollection $positions): self
    {
        $this->positions = new ArrayCollection();
        foreach ($positions as $position) {
            $this->addPosition($position);
        }
        return $this;
    }

    public function removePosition(Position $position): self
    {
        if ($this->positions->contains($position)) {
            $this->positions->removeElement($position);
            // set the owning side to null (unless already changed)
            if ($position->getList() === $this) {
                $position->setList(null);
            }
        }
        return $this;
    }

    public function getChecked(): Collection
    {
        return $this->getPositions()
            ->filter(
                function(Position $position) {
                    return $position->getChecked();
                }
            );
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;
        return $this;
    }
}
