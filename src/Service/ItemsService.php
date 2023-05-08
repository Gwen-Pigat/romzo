<?php

namespace App\Service;

use App\Entity\Items;

class ItemsService extends CoreService
{

    public function getItems():array
    {
        return $this->entityManager->getRepository(Items::class)->findAllItems();
    }

}