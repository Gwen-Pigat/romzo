<?php

namespace App\Controller;

use App\Entity\Items;
use App\Entity\ItemsSpecs;
use App\Entity\User;
use App\Form\ItemsSpecsType;
use App\Form\ItemsType;
use App\Form\UserType;
use App\Service\AdminService;
use App\Service\ItemsService;
use App\Service\ItemsSpecsService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{

    private ItemsService $itemsService;
    private ItemsSpecsService $itemsSpecsService;

    public function __construct(ItemsService $itemsService, ItemsSpecsService $itemsSpecsService)
    {
        $this->itemsService = $itemsService;
        $this->itemsSpecsService = $itemsSpecsService;
    }

    #[Route('/admin', name: 'app_admin')]
    public function index(AdminService $adminService, Request $request): Response
    {
        $user = $adminService->getUser($request);
        if(!$user instanceof User){
            return $this->render('admin/connect.html.twig', [
                "userForm"=>$this->createForm(UserType::class)->createView()
            ]);
        }
        return $this->render('admin/index.html.twig', [
            "user"=>$user,
            "items"=>$this->itemsService->getItems(),
            "itemsSpecs"=>$this->itemsSpecsService->getItemsSpecs()
        ]);
    }

    #[Route('/admin/items/add', name: 'app_admin_items_add')]
    public function adminItemsAdd(): Response
    {
        return $this->render('admin/items/add.html.twig', [
            "title"=>"Ajouter un item",
            "user"=>$this->getUser(),
            "itemsSpecs"=>$this->itemsSpecsService->getItemsSpecs(),
            "itemForm"=>$this->createForm(ItemsType::class)->createView(),
        ]);
    }

    #[Route('/admin/items/add/{id}', name: 'app_admin_items_update')]
    public function adminItemsUpdate(Items $items): Response
    {
        return $this->render('admin/items/add.html.twig', [
            "title"=>"Modifier ".$items->getName(),
            "item"=>$items,
            "user"=>$this->getUser(),
            "itemsSpecs"=>$this->itemsSpecsService->getItemsSpecs(),
            "itemForm"=>$this->createForm(ItemsType::class, $items)->createView(),
        ]);
    }

    #[Route('/admin/itemsSpecs/add', name: 'app_admin_items_specs_add')]
    public function adminItemsSpecsAdd(): Response
    {
        return $this->render('admin/itemsSpecs/add.html.twig', [
            "title"=>"Ajouter une spécificité technique",
            "user"=>$this->getUser(),
            "itemSpecForm"=>$this->createForm(ItemsSpecsType::class)->createView(),
        ]);
    }

    #[Route('/admin/itemsSpecs/add/{id}', name: 'app_admin_items_specs_update')]
    public function adminItemsSpecsUpdate(ItemsSpecs $itemsSpecs): Response
    {
        return $this->render('admin/itemsSpecs/add.html.twig', [
            "title"=>"Modifier ".$itemsSpecs->getName(),
            "itemSpec"=>$itemsSpecs,
            "user"=>$this->getUser(),
            "itemSpecForm"=>$this->createForm(ItemsSpecsType::class, $itemsSpecs)->createView(),
        ]);
    }

}
