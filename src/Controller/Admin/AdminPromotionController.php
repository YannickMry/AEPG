<?php

namespace App\Controller\Admin;

use App\Entity\Promotion;
use App\Form\PromotionType;
use App\Repository\PromotionRepository;
use App\Service\EmailService;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/admin/promotion", name="admin_promotion_")
 */
class AdminPromotionController extends AbstractController
{
    /**
     * @Route("/", name="index", methods="GET")
     */
    public function index(PromotionRepository $promotionRepository): Response
    {
        return $this->render('admin/promotion/index.html.twig', [
            'promotions' => $promotionRepository->findBy([], ['year' => 'DESC']),
        ]);
    }

    /**
     * @Route("/creation", name="create", methods="GET|POST")
     */
    public function create(Request $request, EntityManagerInterface $em): Response
    {
        $promotion = new Promotion();

        $form = $this->createForm(PromotionType::class, $promotion);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($promotion);
            $em->flush();
            $this->addFlash(
                'success',
                "L'promotion '{$promotion->getYear()}' a bien été créé"
            );

            return $this->redirectToRoute('admin_promotion_show', ['year' => $promotion->getYear()]);
        }

        return $this->render('admin/promotion/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{year}", name="show", methods="GET")
     */
    public function show(Promotion $promotion): Response
    {

        return $this->render('admin/promotion/show.html.twig', [
            'promotion' => $promotion,
        ]);
    }

    /**
     * @Route("/{year}/modification", name="edit", methods="GET|POST")
     */
    public function edit(string $year, Request $request, EntityManagerInterface $em): Response
    {
        $promotion = $em->getRepository(Promotion::class)->findOneBy(['year' => $year]);

        $form = $this->createForm(PromotionType::class, $promotion);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($promotion);
            $em->flush();
            $this->addFlash(
                'success',
                "L'promotion '{$promotion->getYear()}' a bien été modifiée."
            );

            return $this->redirectToRoute('admin_promotion_show', ['year' => $promotion->getYear()]);
        }

        return $this->render('admin/promotion/edit.html.twig', [
            'year' => $year,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/{year}/send-appear-renewal", name="send_appear_renewal")
     *
     * @param Promotion $promotion
     * @return Response
     */
    public function sendEmailToAllMembers(
        Promotion $promotion,
        EntityManagerInterface $em,
        EmailService $emailService
    ): Response {
        $members = $promotion->getMembers();

        foreach ($members as $member) {

            $emailService->sendEmailRenewal($member);

            $member->setRenewalSentAt(new DateTimeImmutable());
        }

        $this->addFlash('success', "Les emails ont bien été envoyés !");

        return $this->redirectToRoute('admin_promotion_show', ['year' => $promotion->getYear()]);
    }
}
