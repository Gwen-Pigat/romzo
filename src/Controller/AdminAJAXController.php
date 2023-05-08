<?php

namespace App\Controller;

use App\Entity\Items;
use App\Entity\ItemsSpecs;
use App\Entity\User;
use App\Form\ItemsSpecsType;
use App\Form\ItemsType;
use App\Form\UserType;
use App\Service\AdminService;
use App\Service\CoreService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminAJAXController extends AbstractController
{

    private AdminService $adminService;

    public function __construct(AdminService $adminService)
    {
        $this->adminService = $adminService;
    }


    #[Route('/admin/login/call', name: 'app_admin_login_call')]
    public function adminLoginCall(Request $request): JsonResponse
    {
        return new JsonResponse($this->adminService->setUserConnect($this->createForm(UserType::class, new User())->submit($request->request->all()["user"], false)->getData()));
    }

    #[Route('/admin/items/add/call', name: 'app_admin_items_add_call')]
    public function adminItemsAddCall(Request $request): Response
    {
        $item = new Items();
        if($request->query->get("id") !== null){
            $itemFetch = $this->adminService->entityManager->getRepository(Items::class)->findOneBy(["isActive"=>true,"id"=>$request->query->get("id")]);
            if($itemFetch instanceof Items){
                $item = $itemFetch;
            }
        }
        return new JsonResponse($this->adminService->setItems($this->createForm(ItemsType::class, $item)->submit($request->request->all()["items"], false)->getData()));
    }

    #[Route('/admin/items/handleState/call', name: 'app_admin_items_handle_state_call')]
    public function adminItemsHandleStateCall(Request $request): Response
    {
        $items = $this->adminService->entityManager->getRepository(Items::class)->findOneBy(["isActive"=>true,"id"=>$request->query->get("id")]);
        if(!$items instanceof Items){
            return new JsonResponse(CoreService::returnMessage("L'item n'a pas pu être récupéré"));
        }
        return new JsonResponse($this->adminService->setItemsIsActive($items));
    }

    #[Route('/admin/items/specs/add/call', name: 'app_admin_items_specs_add_call')]
    public function adminItemsSpecsAddCall(Request $request): Response
    {
        $itemSpec = new ItemsSpecs();
        if($request->query->get("id") !== null){
            $itemSpecFetch = $this->adminService->entityManager->getRepository(ItemsSpecs::class)->findOneBy(["isActive"=>true,"id"=>$request->query->get("id")]);
            if($itemSpecFetch instanceof ItemsSpecs){
                $itemSpec = $itemSpecFetch;
            }
        }
        return new JsonResponse($this->adminService->setItemsSpecs($this->createForm(ItemsSpecsType::class, $itemSpec)->submit($request->request->all()["items_specs"], false)->getData()));
    }


}