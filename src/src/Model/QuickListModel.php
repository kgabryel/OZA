<?php


namespace App\Model;


use App\Entity\QuickList\QuickList;
use Doctrine\Common\Collections\ArrayCollection;

class QuickListModel
{
    private ?string $name;

    private ?ArrayCollection $products;

    public function __construct()
    {
        $this->name='';
        $this->products=new ArrayCollection();
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string|null $name
     */
    public function setName(?string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return ArrayCollection|null
     */
    public function getProducts(): ?ArrayCollection
    {
        return $this->products;
    }

    /**
     * @param ArrayCollection|null $products
     */
    public function setProducts(?ArrayCollection $products): void
    {
     $this->products = $products;
    }
    public function getList():QuickList{
        $list=new QuickList();
        $list->setName($this->name);
        $list->addPositions($this->products);
        return $list;
    }
}