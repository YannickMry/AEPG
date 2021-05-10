<?php

namespace App\Service;

use App\Entity\Member;
use App\Entity\User;
use DateTimeImmutable;
use Symfony\Component\Mime\Address;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;

class EmailService
{
    private MailerInterface $mailer;
    private EntityManagerInterface $em;

    public function __construct(MailerInterface $mailer, EntityManagerInterface $em)
    {
        $this->mailer = $mailer;
        $this->em = $em;
    }

    public function sendEmailRenewal(Member $member)
    {
        $answers = [
            'oui' => md5('oui'),
            'non' => md5('non'),
            'jamais' => md5('jamais'),
        ];

        

        $email = (new TemplatedEmail())
                ->from(new Address('noreply@aepg.fr', "Association des étudiants pénalistes de Grenoble"))
                ->to(new Address($member->getEmail(), $member->getFullName()))
                ->subject("Renouvellement d'apparition sur le site AEPG")
                ->htmlTemplate('emails/renewal.html.twig')
                ->context([
                    'token' => $member->getRenewalToken(),
                    'answers' => $answers,
                ]);

        $this->mailer->send($email);
    }

    /**
     * Envoi d'un email afin que l'utilisateur puisse créer son mot de passe
     *
     * @param User $user
     * @return void
     */
    public function sendCreateAccount(User $user): void
    {
        $token = hash("sha256", sprintf("%d-%s", $user->getId(), strtolower($user->getLastname())));

        $user->setToken($token)
            ->setPassword('create');
        $this->em->persist($user);
        $this->em->flush();

        $email = (new TemplatedEmail())
                ->from(new Address('noreply@aepg.fr', "Association des étudiants pénalistes de Grenoble"))
                ->to(new Address($user->getEmail(), $user->getFullName()))
                ->subject("Création du compte AEPG")
                ->htmlTemplate('emails/create_account.html.twig')
                ->context([
                    'token' => $token,
                ]);

        $this->mailer->send($email);
    }
}
