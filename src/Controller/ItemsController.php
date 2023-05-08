<?php

namespace App\Controller;

use App\Service\CoreService;
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
    public function index(): Response
    {
        return $this->render('items/index.html.twig', [
            'constants'=>$this->coreService->getConstants(),
            'controller_name' => 'ItemsController',
        ]);
    }


}
