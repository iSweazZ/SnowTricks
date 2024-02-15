<?php

namespace App\Controller;

use App\Entity\ResetPassword;
use App\Form\NewPasswordType;
use App\Form\ResetPasswordType;
use App\Repository\ResetPasswordRepository;
use App\Repository\UserRepository;
use App\Services\Mailer;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    #[Route(path: '/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        if ($this->getUser()) {
            return $this->redirectToRoute('welcome');
        }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error
        ]);
    }

    #[Route(path: '/lost_password', name: 'app_lost_password')]
    public function lostPassword(AuthenticationUtils $authenticationUtils): Response
    {
        if ($this->getUser()) {
            return $this->redirectToRoute('welcome');
        }
        $lastUsername = $authenticationUtils->getLastUsername();

        $form = $this->createForm(ResetPasswordType::class);
        return $this->render('security/forgotPassword.html.twig', [
            'last_username' => $lastUsername,
            'form' => $form
        ]);
    }

    #[Route(path: '/reset_password', name: 'app_rst_password')]
    public function resetPswd(Request $request, UserRepository $userRepository, ResetPasswordRepository $resetPasswordRepository, Mailer $mailer): Response
    {
        $form = $this->createForm(ResetPasswordType::class);
        $form->handleRequest($request);
        $user = $userRepository->findByEmail($form->get("mail")->getData());
        $random_code = random_bytes(15);
        $resetPassword = new ResetPassword();
        $resetPassword->setCode(bin2hex($random_code));
        $resetPassword->setUser($user);
        $resetPasswordRepository->save($resetPassword);
        $mailer->resetPassword($user, $resetPassword);
        return $this->redirectToRoute('app_login');
    }

    #[Route(path: '/reset_password/{code}/new', name: 'app_regenerate_password')]
    #[ParamConverter("reset_password", class: ResetPassword::class)]
    public function newPassword(ResetPassword $resetPassword): RedirectResponse | Response
    {
        $form = $this->createForm(NewPasswordType::class);
        return $this->render('user/resetPassword.html.twig', [
            'form' => $form->createView(),
        ]);
    }


    #[Route(path: '/reset_password/{code}/set', name: 'app_set_new_password')]
    #[ParamConverter("reset_password", class: ResetPassword::class)]
    public function setPassword(ResetPassword $resetPassword, Request $request, ResetPasswordRepository $resetPasswordRepository, UserRepository $userRepository, UserPasswordHasherInterface $userPasswordHasher, Security $security): RedirectResponse | Response
    {
        $form = $this->createForm(NewPasswordType::class, null);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get("password")->getData() === $form->get("confirmPassword")->getData()) {
                $user = $resetPassword->getUser();
                $user->setPassword($userPasswordHasher->hashPassword($user, $form->get("password")->getData()));
                $userRepository->save($user);
                $resetPasswordRepository->remove($resetPassword);
            }

            return $this->redirectToRoute('app_login');
        }
    }

    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}
