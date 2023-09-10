<?php

namespace App\Controller;

use App\Entity\Comments;
use App\Entity\Tricks;
use App\Entity\User;
use App\Form\CommentType;
use App\Repository\CommentsRepository;
use App\Repository\UserRepository;
use Carbon\Carbon;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CommentController extends AbstractController
{
    #[Route('/trick/{id}/comment', name: 'app_comment',methods: ['POST'])]
    public function store(#[MapEntity(id:'id')] Tricks $trick, Request $request, EntityManagerInterface $entityManager): RedirectResponse
    {
        $comment = new Comments();
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $comment->setAuthor($this->getUser());
            $comment->setDate(Carbon::now());
            $comment->setTrick($trick);
        }
        $entityManager->persist($comment);
        $entityManager->flush();
        return $this->redirectToRoute('app_trick', array(
            'id' => $trick->getId(),
        ));
    }

    #[Route('/comment/{id}/delete', name: 'app_comment_delete')]
    public function delete(#[MapEntity(id:'id')] Comments $comment, Request $request, EntityManagerInterface $entityManager): RedirectResponse
    {
        if($comment->getAuthor() === $this->getUser())
        {
            $entityManager->remove($comment);
            $entityManager->flush();
        }
        return $this->redirectToRoute('app_trick', array(
            'id' => $comment->getTrick()->getId(),
        ));
    }
}
