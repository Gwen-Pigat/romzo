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

    public static function getItemsSpecsByItem(Items $items, $byId=false):array
    {
        if($items->getItemsSpecsItems()->isEmpty()){
            return [];
        }
        $specs = [];
        if ($items->getItemsSpecsItems() instanceof PersistentCollection && !empty($items->getItemsSpecsItems()->getValues())) {
            $iteration = 0;
            foreach ($items->getItemsSpecsItems()->getValues() as $oneValue) {
                if($oneValue->getValue() !== null) {
                    if($byId !== false){
                        $iteration = $oneValue->getRefItemsSpecs()->getId();
                    }
                    $specs[$iteration] = [
                        "value" => $oneValue->getValue(),
                        "name" => $oneValue->getRefItemsSpecs()->getName()
                    ];
                    $iteration++;
                }
            }
        }
        return $specs;
    }

    public static function wrapItemToArray(Items $item, bool $fetchSpecs=true, bool $fetchScore=false):array
    {
        $oneData = (array)$item;
        if (empty($oneData)) {
            return [];
        }
        foreach ($oneData as $key => $value) {
            unset($oneData[$key]);
            if ($value === null) {
                continue;
            }
            $elements = explode("\x00", $key);
            if(!isset($elements[2])){
                continue;
            }
            $keyTransformed = $elements[2];
            switch ($keyTransformed) {
                case "dateAdd":
                case "dateUpdate":
                    $value = $value->format("d/m/Y H:i");
                    break;
                case "image":
                    $value = "https://" . $_SERVER["SERVER_NAME"] . "/" . $value;
                    break;
                case "itemsSpecsItems":
                    if($fetchSpecs === true) {
                        $specs = [];
                        if ($value instanceof PersistentCollection && !empty($value->getValues())) {
                            foreach ($value->getValues() as $oneValue) {
                                if ($oneValue->getValue() !== null) {
                                    $specs[$oneValue->getRefItemsSpecs()->getId()] = [
                                        "value" => $oneValue->getValue(),
                                        "name" => $oneValue->getRefItemsSpecs()->getName()
                                    ];
                                }
                            }
                            if (!empty($specs)) {
                                $value = $specs;
                            }
                        }
                    }
                    if($fetchScore === true && $value instanceof PersistentCollection && !empty($value->getValues())){
                        $oneData["scoreTotal"] = 0;
                        foreach ($value->getValues() as $oneValue) {
                            if ($oneValue->getValue() !== null) {
                                $oneData["scoreTotal"] += $oneValue->getValue();
                            }
                        }
                    }
                break;
            }
            $oneData[$keyTransformed] = $value;
        }
        return $oneData;
    }

}