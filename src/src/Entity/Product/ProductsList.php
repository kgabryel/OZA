<?php

namespace App\Entity\Product;

use App\Entity\Alert\Alert;
use App\Entity\ListInterface;
use App\Entity\User;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\Product\ListRepository")
 * @ORM\Table(name="products_lists")
 * @ORM\HasLifecycleCallbacks()
 */
class ProductsList implements ListInterface
{
    private EntityManagerInterface $entityManager;
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="lists")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="string", length=40)
     */
    private $name;


    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Product\Position", mappedBy="list", cascade="all")
     */
    private $positions;

    public function __construct()
    {
        $this->createdAt= new \DateTime();
        $this->positions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
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
            $position->setList($this);
        }

        return $this;
    }

    public function removeListPosition(Position $position): self
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

    /**
     * @ORM\PostLoad
     * @ORM\PostPersist
     */
    public function fetchEntityManager(LifecycleEventArgs $args)
    {
        $this->entityManager = $args->getEntityManager();
    }

    public function setEntityManager(EntityManagerInterface $entityManager): void
    {
        $this->entityManager = $entityManager;
    }

    public function getAlerts(): array
    {
        return $this->entityManager->createQueryBuilder()
            ->select('a')
            ->from(Alert::class, 'a')
            ->join('a.positions', 'p')
            ->join('p.list', 'l')
            ->where('l.id = :id')
            ->andWhere('a.isActive = true')
            ->setParameter('id', $this->id)
            ->getQuery()
            ->getResult();
    }

    public function getChecked(): Collection
    {
        return $this->getPositions()->filter(function(Position $position){
            return $position->getChecked();
        });
    }
}
