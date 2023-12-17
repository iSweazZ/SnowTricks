<?php

namespace App\Controller;

use App\Entity\Comments;
use App\Entity\Tricks;
use App\Entity\User;
use App\Form\CommentType;
use App\Repository\CommentsRepository;
use App\Repository\UserRepository;
use Carbon\Carbon;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class CommentController extends AbstractController
{
    #[IsGranted('ROLE_USER')]
    #[Route('/trick/{id}/comment', name: 'app_comment',methods: ['POST'])]
    public function store(#[MapEntity(id:'id')] Tricks $trick, Request $request, CommentsRepository $commentsRepository): RedirectResponse
    {
        $comment = new Comments();
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $comment->setAuthor($this->getUser());
            $comment->setDate(new DateTime());
            $comment->setTrick($trick);
            $commentsRepository->save($comment);
        }
        return $this->redirectToRoute('app_trick', array(
            'id' => $trick->getId(),
        ));
    }

    #[Route('/comment/{id}/delete', name: 'app_comment_delete')]
    public function delete(#[MapEntity(id:'id')] Comments $comment, Request $request, CommentsRepository $commentsRepository): RedirectResponse
    {
        if($comment->getAuthor()->getId() === $this->getUser()->getId())
        {
            $commentsRepository->remove($comment);
        }
        return $this->redirectToRoute('app_trick', array(
            'id' => $comment->getTrick()->getId(),
        ));
    }
}
