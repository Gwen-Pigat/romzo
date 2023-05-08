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