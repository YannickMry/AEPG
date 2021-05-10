<?php

namespace App\MessageHandler;

use App\Message\MailMemberRenewal;
use Symfony\Component\Mime\Address;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class MailMemberRenewalHandler implements MessageHandlerInterface
{
    private MailerInterface $mailer;

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    public function __invoke(MailMemberRenewal $message)
    {
        $answers = [
            'oui' => md5('oui'),
            'non' => md5('non'),
            'jamais' => md5('jamais'),
        ];        

        $email = (new TemplatedEmail())
                ->from(new Address('noreply@aepg.fr', "Association des étudiants pénalistes de Grenoble"))
                ->to(new Address($message->getEmail(), $message->getFullName()))
                ->subject("Renouvellement d'apparition sur le site AEPG")
                ->htmlTemplate('emails/renewal.html.twig')
                ->context([
                    'token' => $message->getRenewalToken(),
                    'answers' => $answers,
                ]);
        
        sleep(1);

        $this->mailer->send($email);
    }
}