<?php

namespace App\Controller;

use App\Entity\Coments;
use App\Repository\ComentsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ComentController extends AbstractController
{
    #[Route('/coment', name: 'app_coment')]
    public function store(): int
    {
        $coment = new Coments();
        //$coment->setTrick();
    }

    #[Route('/coment/delete', name: 'app_coment_delete')]
    public function delete(): int
    {

    }
}
