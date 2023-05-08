<?php

namespace App\Service;

use App\Entity\Items;
use App\Entity\ItemsSpecs;
use App\Entity\User;
use App\Security\UserService;
use Symfony\Component\HttpFoundation\Request;

class AdminService extends CoreService
{

    public function getUser(Request $request):?User
    {
        $userID = $request->cookies->get($_ENV["COOKIE_NAME_USER"]);
        if($userID === null){
            return null;
        }
        $userToFetch = $this->entityManager->getRepository(User::class)->findUser($userID);
        if(!$userToFetch instanceof User){
            return null;
        }
        return $userToFetch;
    }

    public function setUserConnect(User $user):array
    {
        $userToFetch = $this->entityManager->getRepository(User::class)->findUser($user->getEmail());
        if(!$userToFetch instanceof User){
            return CoreService::returnMessage("L'utilisateur n'a pas pu être récupéré");
        }
        if(!password_verify($user->getPassword(), $userToFetch->getPassword())){
            return CoreService::returnMessage("Mot de passe incorrect");
        }
        UserService::setUserSession($userToFetch);
        UserService::setUserCookie($userToFetch);
        return CoreService::returnMessage([
            "url"=>[
                "value"=>$this->router->generate("app_admin"),
            ],
            "message"=>"Connexion réussie, redirection en cours"
        ], 200, false);
    }


    public function setItems(Items $items):array
    {
        if($items->getId() === null){
            $items->setDateAdd(new \DateTime());
            $items->setIsActive(true);
            $message = "Item ajouté, redirection en cours";
        } else{
            $items->setDateUpdate(new \DateTime());
            $message = "Item modifié, redirection en cours";
        }
        $this->entityManager->persist($items);
        $this->entityManager->flush();
        return CoreService::returnMessage([
            "url"=>[
                "value"=>$this->router->generate("app_admin"),
            ],
            "message"=>$message
        ], 200, false);
    }

    public function setItemsSpecs(ItemsSpecs $itemsSpecs):array
    {
        if($itemsSpecs->getId() === null){
            $itemsSpecs->setIsActive(true);
            $message = "Spécificité technique ajoutée, redirection en cours";
        } else{
            $message = "Spécificité technique modifiée, redirection en cours";
        }
        $this->entityManager->persist($itemsSpecs);
        $this->entityManager->flush();
        return CoreService::returnMessage([
            "url"=>[
                "value"=>$this->router->generate("app_admin"),
            ],
            "message"=>$message
        ], 200, false);
    }

    public function setItemsIsActive(Items $items):array
    {
        if($items->isIsActive() === true){
            $items->setIsActive(false);
        } else{
            $items->setIsActive(true);
        }
        $this->entityManager->persist($items);
        $this->entityManager->flush();
        return CoreService::returnMessage([
            "message"=>"MAJ OK"
        ], 200, false);
    }

}