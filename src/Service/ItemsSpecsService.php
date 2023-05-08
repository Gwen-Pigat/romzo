<?php

namespace App\Service;

use App\Entity\ItemsSpecs;

class ItemsSpecsService extends CoreService
{


    public function getItemsSpecs():array
    {
        return $this->entityManager->getRepository(ItemsSpecs::class)->findAllItemsSpecs();
    }

}