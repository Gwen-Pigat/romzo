<?php

namespace App\Service;

use App\Entity\Items;
use App\Entity\ItemsSpecs;
use App\Entity\ItemsSpecsItems;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class ItemsSpecsService extends CoreService
{

    private CONST CONFIG = [
        "limit"=>3
    ];

    public function getItemsSpecs(bool $isActiveOnly=true):array
    {
        return $this->entityManager->getRepository(ItemsSpecs::class)->findAllItemsSpecs($isActiveOnly);
    }

    public function validateQuiz(Request $request):array
    {
        $items = $this->entityManager->getRepository(Items::class)->findAllItems(true, "entity");
        if(empty($items)){
            return CoreService::returnMessage("Aucun item n'a pu être récupéré");
        }
        if($request->request->get("specs") === null || $request->request->get("specs") === ""){
            return $this->validateQuizForAllSpecs($items);
        }
        return $this->validateQuizForSpecs($request, $items);

    }

    private function validateQuizForAllSpecs(array $items):array
    {
        $itemsSpecs = $this->entityManager->getRepository(ItemsSpecs::class)->findAllItemsSpecs(true);
        if(empty($itemsSpecs)){
            return CoreService::returnMessage("Les spécificitées demandées n'ont pas pu être récupérées");
        }
        $data = [];
        foreach($items as $item){
            $itemTransform = ItemsService::wrapItemToArray($item, false, true);
            $data[str_pad($itemTransform["scoreTotal"],4,"0", STR_PAD_LEFT)." ".$item->getId()] = $itemTransform;
        }
        if(empty($data)){
            return CoreService::returnMessage("Aucune console ne semble correspondre aux critères recherchés");
        }
        krsort($data);
        return CoreService::returnMessage(["items"=>array_values(array_slice($data, 0, self::CONFIG["limit"]))],200,false);
    }

    private function validateQuizForSpecs(Request $request, array $items):array
    {
        $specs = explode(",", $request->request->get("specs"));
        if(empty($specs)){
            return CoreService::returnMessage("Specs introuvables");
        }
        $itemsSpecs = $this->entityManager->getRepository(ItemsSpecs::class)->findAllItemsSpecs(true, $specs);
        if(empty($itemsSpecs)){
            return CoreService::returnMessage("Les spécificitées demandées n'ont pas pu être récupérées");
        }
        $data = [];
        foreach($items as $item){
            $item->specs = ItemsService::getItemsSpecsByItem($item, true);
            foreach($specs as $spec){
                if(array_key_exists($spec, $item->specs)){
                    if(!isset($data[$item->getId()])){
                        $data[$item->getId()] = [
                            "entity"=>ItemsService::wrapItemToArray($item, false, true),
                            "score"=>0
                        ];
                    }
                    $data[$item->getId()]["score"] += $item->specs[$spec]["value"];
                }
            }
            if(isset($data[$item->getId()])){
                $data[$item->getId()]["entity"]["score"] = $data[$item->getId()]["score"];
                $data[str_pad($data[$item->getId()]["score"],4,"0", STR_PAD_LEFT)." ".$item->getId()] = $data[$item->getId()]["entity"];
                unset($data[$item->getId()]);
            }
            unset($item->specs);
        }
        if(empty($data)){
            return CoreService::returnMessage("Aucune console ne semble correspondre aux critères recherchés");
        }
        krsort($data);
        //dd(array_values(array_slice($data, 0, self::CONFIG["limit"])));
        return CoreService::returnMessage(["items"=>array_values(array_slice($data, 0, self::CONFIG["limit"]))],200,false);
    }

}