<?php

namespace App\Service;

use App\Entity\Constants;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\RouterInterface;

class CoreService
{

    public EntityManagerInterface $entityManager;
    public RouterInterface $router;

    public function __construct(EntityManagerInterface $entityManager, RouterInterface $router)
    {
        $this->entityManager = $entityManager;
        $this->router = $router;
    }

    public function getConstants():array
    {
        return $this->entityManager->getRepository(Constants::class)->findAllByColumn();
    }



    public static function wrapEntitiesToArray(mixed $items, string $column=null):array
    {
        $data = [];
        foreach($items as $keyI=>$item) {
            $oneData = (array)$item;
            if (empty($oneData)) {
                continue;
            }
            foreach ($oneData as $key => $value) {
                unset($oneData[$key]);
                if ($value === null) {
                    continue;
                }
                $oneData[explode("\x00", $key)[2]] = $value;
            }
            if(empty($oneData)){
                continue;
            }
            if($column !== null && array_key_exists($column,$oneData)){
                $keyI = $oneData[$column];
            }
            $data[$keyI] = $oneData;
        }
        return $data;
    }


    public static function rewrite(string $str):string
    {
        return preg_replace("/[\/_|+ -]+/", '-', strtolower(trim(preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', iconv('UTF-8', 'ASCII//TRANSLIT', $str)), '-')));
    }


    public static function returnMessage(string|array $message, int $status=200, bool $isError=true):array
    {
        if($isError === true){
            return [
                "status"=>$status,
                "data"=>["error"=>$message]
            ];
        }
        return ["status"=>$status, "data"=>$message];
    }


}