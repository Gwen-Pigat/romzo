<?php

namespace App\Entity;

use App\Repository\ItemsSpecsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ItemsSpecsRepository::class)]
class ItemsSpecs
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $name = null;

    #[ORM\Column(nullable: true)]
    private ?int $valueMax = null;

    #[ORM\Column(nullable: true)]
    private ?int $placement = null;

    #[ORM\Column]
    private ?bool $isActive = null;

    #[ORM\OneToMany(mappedBy: 'refItemsSpecs', targetEntity: ItemsSpecsItems::class, orphanRemoval: true)]
    private Collection $itemsSpecsItems;

    public function __construct()
    {
        $this->itemsSpecsItems = new ArrayCollection();
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
        $this->name = $name;

        return $this;
    }

    public function getValueMax(): ?int
    {
        return $this->valueMax;
    }

    public function setValueMax(?int $valueMax): self
    {
        $this->valueMax = $valueMax;

        return $this;
    }

    public function getPlacement(): ?int
    {
        return $this->placement;
    }

    public function setPlacement(?int $placement): self
    {
        $this->placement = $placement;

        return $this;
    }

    public function isIsActive(): ?bool
    {
        return $this->isActive;
    }

    public function setIsActive(bool $isActive): self
    {
        $this->isActive = $isActive;

        return $this;
    }

    /**
     * @return Collection<int, ItemsSpecsItems>
     */
    public function getItemsSpecsItems(): Collection
    {
        return $this->itemsSpecsItems;
    }

    public function addItemsSpecsItem(ItemsSpecsItems $itemsSpecsItem): self
    {
        if (!$this->itemsSpecsItems->contains($itemsSpecsItem)) {
            $this->itemsSpecsItems->add($itemsSpecsItem);
            $itemsSpecsItem->setRefItemsSpecs($this);
        }

        return $this;
    }

    public function removeItemsSpecsItem(ItemsSpecsItems $itemsSpecsItem): self
    {
        if ($this->itemsSpecsItems->removeElement($itemsSpecsItem)) {
            // set the owning side to null (unless already changed)
            if ($itemsSpecsItem->getRefItemsSpecs() === $this) {
                $itemsSpecsItem->setRefItemsSpecs(null);
            }
        }

        return $this;
    }
}
