<?php

namespace App\Entity;

use App\Entity\Alert\Alert;
use App\Entity\Product\Product;
use App\Entity\Product\ProductsList;
use App\Entity\QuickList\QuickList;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @UniqueEntity(fields={"email"}, message="There is already an account with this email")
 * @ORM\Table(name="users")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\OneToMany(targetEntity="Measure", mappedBy="user")
     */
    private $measures;

    /**
     * @ORM\Column(type="integer")
     */
    private $userType;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\QuickList\QuickList", mappedBy="user")
     */
    private $quickLists;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Shop", mappedBy="user")
     */
    private $shops;

    /**
     * @ORM\Column(type="bigint", nullable=true)
     */
    private $fbId;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Product\Product", mappedBy="user")
     */
    private $products;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Alert\Alert", mappedBy="user")
     */
    private $alerts;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Product\ProductsList", mappedBy="user")
     */
    private $lists;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Shopping", mappedBy="user")
     */
    private $shopping;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Note", mappedBy="user")
     */
    private $notes;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $name;

    public function __construct()
    {
        $this->fbId = null;
        $this->id = null;
        $this->password = '';
        $this->userType = 1;
        $this->email = '';
        $this->measures = new ArrayCollection();
        $this->quickLists = new ArrayCollection();
        $this->shops = new ArrayCollection();
        $this->products = new ArrayCollection();
        $this->alerts = new ArrayCollection();
        $this->lists = new ArrayCollection();
        $this->shopping = new ArrayCollection();
        $this->notes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        if ($this->userType === 2) {
            return $this->name === '' ? $this->email : $this->name;
        }
        return $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string)$this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
    }

    /**
     * @return Collection|Measure[]
     */
    public function getMeasures(): Collection
    {
        return $this->measures;
    }

    public function addMeasure(Measure $measure): self
    {
        if (!$this->measures->contains($measure)) {
            $this->measures[] = $measure;
            $measure->setUser($this);
        }

        return $this;
    }

    public function removeMeasure(Measure $measure): self
    {
        if ($this->measures->contains($measure)) {
            $this->measures->removeElement($measure);
            // set the owning side to null (unless already changed)
            if ($measure->getUser() === $this) {
                $measure->setUser(null);
            }
        }

        return $this;
    }

    public function getUserType(): ?int
    {
        return $this->userType;
    }

    public function setUserType(int $userType): self
    {
        $this->userType = $userType;

        return $this;
    }

    /**
     * @return Collection|QuickList[]
     */
    public function getQuickLists(): Collection
    {
        return $this->quickLists;
    }

    public function addQuickList(QuickList $quickList): self
    {
        if (!$this->quickLists->contains($quickList)) {
            $this->quickLists[] = $quickList;
            $quickList->setUser($this);
        }

        return $this;
    }

    public function removeQuickList(QuickList $quickList): self
    {
        if ($this->quickLists->contains($quickList)) {
            $this->quickLists->removeElement($quickList);
            // set the owning side to null (unless already changed)
            if ($quickList->getUser() === $this) {
                $quickList->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Shop[]
     */
    public function getShops(): Collection
    {
        return $this->shops;
    }

    public function addShop(Shop $shop): self
    {
        if (!$this->shops->contains($shop)) {
            $this->shops[] = $shop;
            $shop->setUser($this);
        }

        return $this;
    }

    public function removeShop(Shop $shop): self
    {
        if ($this->shops->contains($shop)) {
            $this->shops->removeElement($shop);
            // set the owning side to null (unless already changed)
            if ($shop->getUser() === $this) {
                $shop->setUser(null);
            }
        }

        return $this;
    }

    public function getFbId(): ?int
    {
        return $this->fbId;
    }

    public function setFbId(?int $fbId): self
    {
        $this->fbId = $fbId;

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
            $product->setUser($this);
        }

        return $this;
    }

    public function removeProduct(Product $product): self
    {
        if ($this->products->contains($product)) {
            $this->products->removeElement($product);
            // set the owning side to null (unless already changed)
            if ($product->getUser() === $this) {
                $product->setUser(null);
            }
        }

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
            $alert->setUser($this);
        }

        return $this;
    }

    public function removeAlert(Alert $alert): self
    {
        if ($this->alerts->contains($alert)) {
            $this->alerts->removeElement($alert);
            // set the owning side to null (unless already changed)
            if ($alert->getUser() === $this) {
                $alert->setUser(null);
            }
        }

        return $this;
    }

    public function getActiveAlerts(): Collection
    {
        return $this->getAlerts()
            ->filter(
                function(Alert $alert) {
                    return $alert->isActive();
                }
            );
    }

    /**
     * @return Collection|ProductsList[]
     */
    public function getLists(): Collection
    {
        return $this->lists;
    }

    public function addList(ProductsList $list): self
    {
        if (!$this->lists->contains($list)) {
            $this->lists[] = $list;
            $list->setUser($this);
        }

        return $this;
    }

    public function removeList(ProductsList $list): self
    {
        if ($this->lists->contains($list)) {
            $this->lists->removeElement($list);
            // set the owning side to null (unless already changed)
            if ($list->getUser() === $this) {
                $list->setUser(null);
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
            $shopping->setUser($this);
        }

        return $this;
    }

    public function removeShopping(Shopping $shopping): self
    {
        if ($this->shopping->contains($shopping)) {
            $this->shopping->removeElement($shopping);
            // set the owning side to null (unless already changed)
            if ($shopping->getUser() === $this) {
                $shopping->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Note[]
     */
    public function getNotes(): Collection
    {
        return $this->notes;
    }

    public function addNote(Note $note): self
    {
        if (!$this->notes->contains($note)) {
            $this->notes[] = $note;
            $note->setUser($this);
        }

        return $this;
    }

    public function removeNote(Note $note): self
    {
        if ($this->notes->contains($note)) {
            $this->notes->removeElement($note);
            // set the owning side to null (unless already changed)
            if ($note->getUser() === $this) {
                $note->setUser(null);
            }
        }

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }
}
