<?php

namespace App\Controller;

use App\Repository\TricksRepository;
use JetBrains\PhpStorm\NoReturn;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/ets', methods: ['GET'])]
    public function index(TricksRepository $tricksRepository): Response
    {
        $tricks = $tricksRepository->findAll();
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }
}
