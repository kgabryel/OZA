<?php


namespace App\Model\Filters;


class Shop
{
    private string $name;
    private string $description;

    public function __construct() {
        $this->name='';
        $this->description='';
    }


    public function getName(): ?string
    {
        return $this->name;
    }


    public function setName(?string $name): void
    {
        if($name===null){
            $name='';
        }
        $this->name = $name;
    }


    public function getDescription(): string
    {
        return $this->description;
    }


    public function setDescription(?string $description): void
    {
        if($description===null){
            $description='';
        }
        $this->description = $description;
    }
}