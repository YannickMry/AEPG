<?php

namespace App\Service;

use App\Entity\Member;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mailer\MailerInterface;

class EmailService
{
    private MailerInterface $mailer;

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    public function sendEmailRenewal(Member $member)
    {
        $email = (new TemplatedEmail())
                ->from(new Address('noreply@aepg.fr', "Association des étudiants pénalistes de Grenoble"))
                ->to(new Address($member->getEmail(), $member->getFullName()))
                ->subject("Renouvellement d'apparition sur le site AEPG")
                ->htmlTemplate('emails/renewal.html.twig');

        $this->mailer->send($email);
    }
}
