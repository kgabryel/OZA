<?php

namespace App\Entity\QuickList;

use App\Entity\PositionInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\QuickList\PositionRepository")
 * @ORM\Table(name="quick_lists_positions")
 */
class Position implements PositionInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private ?int $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $content;

    /**
     * @ORM\Column(type="boolean")
     */
    private bool $checked;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\QuickList\QuickList", inversedBy="positions")
     * @ORM\JoinColumn(nullable=false)
     */
    private ?QuickList $list;

    public function __construct()
    {
        $this->checked = false;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getChecked(): ?bool
    {
        return $this->checked;
    }

    public function check(): self
    {
        $this->checked = true;
        return $this;
    }
    public function unCheck(): self
    {
        $this->checked = false;
        return $this;
    }

    public function getList(): QuickList
    {
        return $this->list;
    }

    public function setList(?QuickList $list): self
    {
        $this->list = $list;

        return $this;
    }
}
