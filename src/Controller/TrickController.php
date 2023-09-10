<?php

namespace App\Controller;

use App\Entity\Comments;
use App\Entity\Tricks;
use App\Form\CommentType;
use App\Repository\TricksRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class TrickController extends AbstractController
{

    #[Route('/trick/{id}', name: 'app_trick')]
    #[ParamConverter("trick", class:Tricks::class)]
    public function index(Tricks $trick, Request $request): Response
    {
        $comment = new Comments();
        $form = $this->createForm(CommentType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            dump($comment);die;
        }
        return $this->render('trick/index.html.twig', [
            'controller_name' => 'TrickController',
            'trick' => $trick,
            'form' => $form->createView()
        ]);
    }

    #[Route('/trick/manage', name: 'app_trick_manager')]
    public function manage(): Response
    {
        return $this->render('trick/manage.html.twig');
    }
}
