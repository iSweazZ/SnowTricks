<?php

namespace App\Controller;

use App\Entity\Coments;
use App\Entity\Tricks;
use App\Repository\ComentsRepository;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ComentController extends AbstractController
{
    #[Route('/trick/{id}/comment', name: 'app_comment',methods: ['POST'])]
    public function store(#[MapEntity(id:'id')] Tricks $trick): int
    {
        $form = $this->createForm();
        $coment = new Coments();
        $coment->setText();
    }

    #[Route('/coment/delete', name: 'app_comment_delete')]
    public function delete(): int
    {

    }
}
