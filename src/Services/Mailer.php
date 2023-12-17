<?php

namespace App\Services;

use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;

class Mailer
{
    public function __construct(private readonly MailerInterface $mailer)
    {}

    public function test()
    {
        $email = (new TemplatedEmail())
            ->from('fabien@example.com')
            ->to(new Address('wissem26500@gmail.com'))
            ->subject('Thanks for signing up!')

            // path of the Twig template to render
            ->htmlTemplate('test.twig');

        $this->mailer->send($email);
    }
}