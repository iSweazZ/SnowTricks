<?php

namespace App\Controller;

use App\Entity\Attachements;
use App\Entity\Comments;
use App\Entity\Tricks;
use App\Form\ChangePasswordType;
use App\Form\CommentType;
use App\Form\EditTrickType;
use App\Form\TrickType;
use App\Repository\AttachementsRepository;
use App\Repository\TricksRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Filesystem\Filesystem;


class TrickController extends AbstractController
{

    public function __construct(
        private RequestStack $requestStack,
    ) {}

    #[Route('/trick/{id}', name: 'app_trick')]
    #[ParamConverter("trick", class:Tricks::class)]
    public function show(Tricks $trick): Response
    {
        $form = $this->createForm(CommentType::class);
        return $this->render('trick/index.html.twig', [
            'controller_name' => 'TrickController',
            'trick' => $trick,
            'form' => $form->createView()
        ]);
    }

    #[Route('/tricks/create', name: 'app_create_trick')]
    public function store(): Response
    {
        $form = $this->createForm(TrickType::class);
        return $this->render('trick/trickCreator.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/tricks/create', name: 'app_edit_tricks')]
    public function storjdfgjgfse(): Response
    {
        $form = $this->createForm(TrickType::class);
        return $this->render('trick/trickCreator.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/trick/{id}/edit', name: 'edit_trick')]
    #[ParamConverter("trick", class:Tricks::class)]
    public function edit(Tricks $trick): Response
    {
        $form = $this->createForm(EditTrickType::class, $trick);
        return $this->render('trick/trickCreator.html.twig', [
            'trickForm' => $form->createView(),
            'trick' => $trick
        ]);
    }

    #[Route('/trick/{id}/save', name: 'save_edit_trick')]
    #[ParamConverter("trick", class:Tricks::class)]
    public function saveEdit(Tricks $trick, Request $request, TricksRepository $tricksRepository, AttachementsRepository $attachementsRepository): Response
    {
        $filesystem = new Filesystem();
        $form = $this->createForm(EditTrickType::class, $trick);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $fileDir = $_SERVER['DOCUMENT_ROOT'] . 'images\tricks';

            $picture = $form->get("picture")->getData();
            $bg = $form->get("bg_img")->getData();
            $trick->setName($form->get("name")->getData());
            $trick->setText($form->get("text")->getData());
            $trick->setDescription($form->get("description")->getData());
            $trick->setCategory($form->get("category")->getData());
            if($picture !== null)
            {
                $picture = $form->get("picture")->getData();
                $pictureName = md5(uniqid()) . "." . $picture->guessExtension();
                $picture->move($fileDir, $pictureName);
                $filesystem->remove($fileDir . '\\' . $trick->getPicture());
                $trick->setPicture($pictureName);
            }

            if($bg !== null)
            {
                $picture = $form->get("bg_img")->getData();
                $pictureName = md5(uniqid()) . "." . $picture->guessExtension();
                $picture->move($fileDir, $pictureName);
                $filesystem->remove($fileDir . '\\' . $trick->getBgImg());
                $trick->setBgImg($pictureName);
            }

            foreach($trick->getAttachements()->toArray() as $att)
            {
                if (!$form->get("check" . $att->getId())->getData())
                {
                    $attachementsRepository->remove($att);
                    $filesystem->remove($fileDir . '\attachments\\' . $att->getPath());
                }
            }

            if($form->get("images")->getData() !== null)
            {
                    foreach ($form->get("images")->getData() as $image)
                    {
                        $imageName = md5(uniqid()) . "." . $image->guessExtension();
                        $image->move($fileDir . '\attachments', $imageName);
                        $attachment = new Attachements();
                        $attachment->setTrick($trick);
                        $attachment->setPath($imageName);
                        $attachment->setType("img");
                        $trick->addAttachement($attachment);
                    }
            }

            $tricksRepository->save($trick);
            return $this->redirectToRoute('welcome');
        }
    }

    #[Route('/tricks/make', name: 'app_store_tricks')]
    public function make(Request $request, TricksRepository $tricksRepository, AttachementsRepository $attachementsRepository): Response
    {
        $trick = new Tricks();
        $form = $this->createForm(TrickType::class, $trick);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $fileDir = $_SERVER['DOCUMENT_ROOT'] . 'images\tricks';

            $picture = $form->get("picture")->getData();

            $pictureName = md5(uniqid()) . "." . $picture->guessExtension();
            $picture->move($fileDir, $pictureName);

            $bgImg = $form->get("bg_img")->getData();
            $bgImgName = md5(uniqid()) . "." . $bgImg->guessExtension();
            $bgImg->move($fileDir, $bgImgName);
            $trick->setPicture($pictureName);
            $trick->setBgImg($bgImgName);
            $trick->setPublisher($this->getUser());
            //dd($trick->getId());
            foreach ($form->get("images")->getData() as $image)
            {
                $imageName = md5(uniqid()) . "." . $image->guessExtension();
                $image->move($fileDir . '\attachments', $imageName);
                $attachment = new Attachements();
                $attachment->setTrick($trick);
                $attachment->setPath($imageName);
                $attachment->setType("img");
                $trick->addAttachement($attachment);
            }
            if($form->get("embed")->getData() !== null)
            {
                $attachment = new Attachements();
                $attachment->setTrick($trick);
                $attachment->setType("embed");
                $attachment->setPath($form->get("embed")->getData());
                $trick->addAttachement($attachment);
            }
            $tricksRepository->save($trick);

        }
        else
        {
            $session = $this->requestStack;
            $session->getSession()->set("message", "Impossible de créer la figure, vérifiez le poids de vos images");
        }
        return $this->redirectToRoute('welcome');


    }

    #[Route('/trick/{id}/delete', name: 'delete_trick')]
    #[ParamConverter("trick", class:Tricks::class)]
    public function delete(Tricks $trick, TricksRepository $TR): Response
    {
        /*if($trick->getPublisher()->getId() === $this->getUser()->getId())
        {*/
            $TR->remove($trick);
        //}
        return $this->redirectToRoute('welcome');
    }

}
