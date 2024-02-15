<?php

namespace App\Services;

use App\Entity\ResetPassword;
use App\Entity\User;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Routing\RouterInterface;

class Mailer
{
    public function __construct(private readonly MailerInterface $mailer, private readonly RouterInterface $router)
    {}

    public function resetPassword(User $user, ResetPassword $resetPassword)
    {
        $email = (new TemplatedEmail())
            ->from('noreply@snowtrick.com')
            ->to(new Address($user->getEmail()))
            ->subject('Mot de passe oublié')
            ->htmlTemplate('resetPassword.twig')
            ->context([
                'lien' => $this->router->generate('app_regenerate_password', ['code' => $resetPassword->getCode()], UrlGeneratorInterface::ABSOLUTE_URL)
            ]);

        $this->mailer->send($email);
    }
}