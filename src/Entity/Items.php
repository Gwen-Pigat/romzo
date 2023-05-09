<?php

namespace App\Entity;

use App\Repository\ItemsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ItemsRepository::class)]
class Items
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $name = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $image = null;

    #[ORM\Column(nullable: true)]
    private ?int $placement = null;

    #[ORM\Column]
    private ?bool $isActive = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $dateAdd = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $dateUpdate = null;

    #[ORM\OneToMany(mappedBy: 'refItems', targetEntity: ItemsSpecsItems::class, orphanRemoval: true)]
    private Collection $itemsSpecsItems;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $youtubeLink = null;

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

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

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

    public function getDateAdd(): ?\DateTimeInterface
    {
        return $this->dateAdd;
    }

    public function setDateAdd(?\DateTimeInterface $dateAdd): self
    {
        $this->dateAdd = $dateAdd;

        return $this;
    }

    public function getDateUpdate(): ?\DateTimeInterface
    {
        return $this->dateUpdate;
    }

    public function setDateUpdate(?\DateTimeInterface $dateUpdate): self
    {
        $this->dateUpdate = $dateUpdate;

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
            $itemsSpecsItem->setRefItems($this);
        }

        return $this;
    }

    public function removeItemsSpecsItem(ItemsSpecsItems $itemsSpecsItem): self
    {
        if ($this->itemsSpecsItems->removeElement($itemsSpecsItem)) {
            // set the owning side to null (unless already changed)
            if ($itemsSpecsItem->getRefItems() === $this) {
                $itemsSpecsItem->setRefItems(null);
            }
        }

        return $this;
    }

    public function getYoutubeLink(): ?string
    {
        return $this->youtubeLink;
    }

    public function setYoutubeLink(?string $youtubeLink): self
    {
        $this->youtubeLink = $youtubeLink;

        return $this;
    }
    
}
