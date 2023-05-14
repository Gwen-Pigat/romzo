<?php

namespace App\Entity;

use App\Repository\ItemsSpecsItemsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ItemsSpecsItemsRepository::class)]
class ItemsSpecsItems
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'itemsSpecsItems')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Items $refItems = null;

    #[ORM\ManyToOne(inversedBy: 'itemsSpecsItems')]
    #[ORM\JoinColumn(nullable: false)]
    private ?ItemsSpecs $refItemsSpecs = null;

    #[ORM\Column(nullable: true)]
    private ?float $value = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRefItems(): ?Items
    {
        return $this->refItems;
    }

    public function setRefItems(?Items $refItems): self
    {
        $this->refItems = $refItems;

        return $this;
    }

    public function getRefItemsSpecs(): ?ItemsSpecs
    {
        return $this->refItemsSpecs;
    }

    public function setRefItemsSpecs(?ItemsSpecs $refItemsSpecs): self
    {
        $this->refItemsSpecs = $refItemsSpecs;

        return $this;
    }

    public function getValue(): ?float
    {
        return $this->value;
    }

    public function setValue(?float $value): self
    {
        $this->value = $value;

        return $this;
    }
}
