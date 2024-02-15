<?php

namespace App\Controller;

use App\Repository\TricksRepository;
use App\Services\Mailer;
use JetBrains\PhpStorm\NoReturn;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    public function __construct(
        private RequestStack $requestStack,
    ) {
    }

    #[Route(path: '/', name: 'welcome', methods: ['GET'])]
    public function index(TricksRepository $tricksRepository): Response
    {
        $session = $this->requestStack;
        $tricks = $tricksRepository->findAll();
        return $this->render('home/index.html.twig', [
            'tricks' => $tricks,
            'session' => $session->getSession()->get("message")
        ]);
    }
}
