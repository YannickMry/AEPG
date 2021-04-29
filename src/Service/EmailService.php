<?php

namespace App\Service;

use App\Entity\Member;
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

        $token = hash("sha256", sprintf("%d-%s", $member->getId(), $member->getSlug()));

        $member->setRenewalAnswer(null)
            ->setRenewalAnswerAt(null)
            ->setRenewalToken($token)
            ->setRenewalSentAt(new DateTimeImmutable());

        $this->em->flush();

        $email = (new TemplatedEmail())
                ->from(new Address('noreply@aepg.fr', "Association des étudiants pénalistes de Grenoble"))
                ->to(new Address($member->getEmail(), $member->getFullName()))
                ->subject("Renouvellement d'apparition sur le site AEPG")
                ->htmlTemplate('emails/renewal.html.twig')
                ->context([
                    'token' => $token,
                    'answers' => $answers,
                ]);

        $this->mailer->send($email);
    }
}
