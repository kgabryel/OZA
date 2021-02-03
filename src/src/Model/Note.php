<?php


namespace App\Model;

use App\Entity\Note as Entity;
class Note
{
    private ?string $content;

    public function __construct()
    {
        $this->content = null;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }


    public function setContent(?string $content): void
    {
        $this->content = $content;
    }
    public function getEntity():Entity{
        $entity= new Entity();
        $entity->setContent($this->content);
        return $entity;
    }
}