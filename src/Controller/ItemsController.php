<?php

namespace App\Controller;

use App\Entity\Items;
use App\Entity\Socials;
use App\Service\CoreService;
use App\Service\ItemsService;
use App\Service\ItemsSpecsService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
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
            'items'=>$itemsService->getItems(),
            'constants'=>$this->coreService->getConstants(),
            'socials'=>CoreService::wrapEntitiesToArray($this->coreService->entityManager->getRepository(Socials::class)->findBy(["isActive"=>true]), "nameKey")
        ]);
    }

    #[Route('/quiz', name: 'app_quiz')]
    public function startQuiz(ItemsSpecsService $itemsSpecsService): Response
    {
        return $this->render('items/quiz.html.twig', [
            'itemsSpecs'=>$itemsSpecsService->getItemsSpecs(),
            'constants'=>$this->coreService->getConstants(),
            'socials'=>CoreService::wrapEntitiesToArray($this->coreService->entityManager->getRepository(Socials::class)->findBy(["isActive"=>true]), "nameKey")
        ]);
    }

    #[Route('/quiz/validate/call', name: 'app_quiz_validate_call')]
    public function validateQuizCall(ItemsSpecsService $itemsSpecsService, Request $request): JsonResponse
    {
        return new JsonResponse($itemsSpecsService->validateQuiz($request));
    }

    #[Route('/items/specs/call', name: 'app_items_specs_call')]
    public function getItemsSpecsCall(ItemsService $itemsService, Request $request): JsonResponse
    {
        if($request->get("id") === null){
            return new JsonResponse(CoreService::returnMessage("ID introuvable"));
        }
        $item = $itemsService->entityManager->getRepository(Items::class)->findOneBy(["isActive"=>true,"id"=>$request->get("id")]);
        if(!$item instanceof Items){
            return new JsonResponse(CoreService::returnMessage("Item introuvable"));
        }
        return new JsonResponse(CoreService::returnMessage(ItemsService::getItemsSpecsByItem($item), 200, false));
    }

}
