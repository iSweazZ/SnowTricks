<?php

namespace App\Controller;

use App\Entity\Comments;
use App\Entity\User;
use App\Form\ChangePasswordType;
use App\Form\CommentType;
use App\Repository\CommentsRepository;
use App\Repository\UserRepository;
use Cassandra\Type\UserType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Bundle\SecurityBundle\SecurityBundle;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Http\Attribute\CurrentUser;

class UserController extends AbstractController
{

    #[Route('/user/{id}/tricks', name: 'user_trick')]
    #[ParamConverter("user", class:User::class)]
    public function show(User $user): Response
    {

    }

    #[Route('/user/manage', name: 'app_trick_manager')]
    public function manage(): Response
    {
        $form = $this->createForm(ChangePasswordType::class);
        return $this->render('trick/manage.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/user/password', name: 'app_change_password', methods: ["POST"])]
    public function changePassword(Request $request, UserRepository $userRepository, UserPasswordHasherInterface $userPasswordHasher, Security $security): RedirectResponse
    {
        $form = $this->createForm(ChangePasswordType::class, null);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $data = $form->getData();
            if($form->get("NewPassword")->getData() === $form->get("Retype")->getData() && $userPasswordHasher->isPasswordValid($this->getUser(), $form->get("currentPassword")->getData()))
            {
                $this->getUser()->setPassword($userPasswordHasher->hashPassword($this->getUser(), $form->get("NewPassword")->getData()));

                $userRepository->save($this->getUser());
                $security->logout(false);
            }

            return $this->redirectToRoute('app_login');

        }
    }
}
