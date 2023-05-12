<?php

namespace App\Controller;

use App\Entity\Socials;
use App\Service\CoreService;
use App\Service\ItemsService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ItemsController extends AbstractController
{

    private CoreService $coreService;

    public function __construct(CoreService $coreService)
    {
        $this->coreService = $coreService;
    }

    #[Route('/', name: 'app_index')]
    public function index(ItemsService $itemsService): Response
    {
        return $this->render('items/index.html.twig', [
            'items'=>ItemsService::wrapItemsToArray($itemsService->getItems(true, "entity")),
            'constants'=>$this->coreService->getConstants(),
            'socials'=>CoreService::wrapEntitiesToArray($this->coreService->entityManager->getRepository(Socials::class)->findBy(["isActive"=>true]), "nameKey")
        ]);
    }


}
