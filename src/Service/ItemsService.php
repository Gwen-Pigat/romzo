<?php

namespace App\Service;

use App\Entity\Items;
use Doctrine\ORM\PersistentCollection;

class ItemsService extends CoreService
{

    public function getItems(bool $isActiveOnly=true, string $mode="scalar"):array
    {
        return $this->entityManager->getRepository(Items::class)->findAllItems($isActiveOnly, $mode);
    }

    public static function wrapItemsToArray(array $items):array
    {
        $data = [];
        foreach($items as $item) {
            $oneData = (array)$item;
            if (empty($oneData)) {
                return [];
            }
            foreach ($oneData as $key => $value) {
                unset($oneData[$key]);
                if ($value === null) {
                    continue;
                }
                $keyTransformed = explode("\x00", $key)[2];
                switch ($keyTransformed) {
                    case "dateAdd":
                    case "dateUpdate":
                        $value = $value->format("d/m/Y H:i");
                        break;
                    case "image":
                        $value = "https://" . $_SERVER["SERVER_NAME"] . "/" . $value;
                        break;
                    case "itemsSpecsItems":
                        $specs = [];
                        if ($value instanceof PersistentCollection && !empty($value->getValues())) {
                            foreach ($value->getValues() as $oneValue) {
                                $specs[$oneValue->getRefItemsSpecs()->getId()] = $oneValue->getValue();
                            }
                            if (!empty($specs)) {
                                $value = $specs;
                            }
                        }
                        break;
                }
                $oneData[$keyTransformed] = $value;
            }
            $data[] = $oneData;
        }
        return $data;
    }

}