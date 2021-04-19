<?php

namespace App\Controller;

use App\Entity\Member;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MemberController extends AbstractController
{
    /**
     * @Route("/renouvellement-d-apparition/{token}/{answer}", name="member_renewal_answer", methods="GET")
     */
    public function index(string $token, string $answer, EntityManagerInterface $em): Response
    {
        /** @var Member $member */
        $member = $em->getRepository(Member::class)->findOneBy(['renewalToken' => $token]);

        $errorMsg = "Oups, une erreur s'est produite...";

        if (!$member) {
            $this->addFlash('danger', $errorMsg);
            return $this->redirectToRoute('promotion_index');
        }

        $answer = htmlspecialchars(strtolower($answer));

        switch ($answer) {
            case md5('oui'):
                $member->setRenewalToken(null)
                    ->setRenewalAnswer('oui')
                    ->setIsHidden(0)
                    ->setRenewalAnswerAt(new DateTimeImmutable());
                $this->addFlash('success', "A partir de maintenant, vous apparaitrez sur le site de l'AEPG !");
                break;

            case md5('non'):
                $member->setRenewalToken(null)
                    ->setRenewalAnswer('non')
                    ->setIsHidden(1)
                    ->setRenewalAnswerAt(new DateTimeImmutable());

                $this->addFlash('success', "A partir de maintenant, vous n'apparaitrez plus sur le site de l'AEPG !
                Toute fois, une nouvelle demande vous sera envoyé l'année prochaine.");
                break;

            case md5('jamais'):
                $member->setRenewalToken(null)
                    ->setRenewalAnswer('jamais')
                    ->setIsHidden(1)
                    ->setRenewalAnswerAt(new DateTimeImmutable());

                $this->addFlash('success', "A partir de maintenant, vous n'apparaitrez plus sur le site de l'AEPG !
                Si vous souhaitez apparaitre sur le site, vous devrez contacter l'administrateur.");
                break;

            default:
                $this->addFlash('danger', $errorMsg);
                break;
        }

        $em->flush();

        return $this->redirectToRoute('promotion_index');
    }
}
