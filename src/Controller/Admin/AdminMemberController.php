<?php

namespace App\Controller\Admin;

use App\Entity\Member;
use App\Entity\Promotion;
use App\Form\MemberType;
use App\Repository\MemberRepository;
use App\Service\EmailService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/admin/member", name="admin_member_")
 */
class AdminMemberController extends AbstractController
{
    /**
     * @Route("/", name="index", methods="GET")
     */
    public function index(MemberRepository $memberRepository): Response
    {
        return $this->render('admin/member/index.html.twig', [
            'members' => $memberRepository->findBy([], ['lastname' => 'ASC', 'firstname' => 'ASC']),
        ]);
    }

    /**
     * @Route("/creation", name="create", methods="GET|POST")
     */
    public function create(Request $request, EntityManagerInterface $em): Response
    {
        $member = new Member();

        if ($request->query->get('year')) {
            $promotion = $em->getRepository(Promotion::class)->findOneBy(['year' => $request->query->get('year')]);
            $member->setPromotion($promotion);
        }

        $form = $this->createForm(MemberType::class, $member);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($member);
            $em->flush();
            $this->addFlash(
                'success',
                "{$member->getFullName()}' a bien été créé"
            );

            return $this->redirectToRoute('admin_member_show', ['slug' => $member->getSlug()]);
        }

        return $this->render('admin/member/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{slug}", name="show", methods="GET")
     */
    public function show(Member $member): Response
    {

        return $this->render('admin/member/show.html.twig', [
            'member' => $member,
        ]);
    }

    /**
     * Envoi un email de renouvellement à un seul membre
     *
     * @Route("/{slug}/envoyer-un-mail-de-renouvellement", name="send_one_renewal", methods="GET")
     *
     * @param Member $member
     * @return Response
     */
    public function sendOneRenewal(Member $member, EmailService $emailService, EntityManagerInterface $em): Response
    {
        $emailService->sendEmailRenewal($member);
        $this->addFlash(
            'success',
            "Un email de renouvellement d'apparition a bien été envoyé à {$member->getFullName()}."
        );
        return $this->redirectToRoute('admin_promotion_index');
    }

    /**
     * @Route("/{slug}/modification", name="edit", methods="GET|POST")
     */
    public function edit(Member $member, Request $request, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(MemberType::class, $member);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($member);
            $em->flush();
            $this->addFlash(
                'success',
                "{$member->getFullName()} a bien été modifiée."
            );

            return $this->redirectToRoute('admin_member_show', ['slug' => $member->getSlug()]);
        }

        return $this->render('admin/member/edit.html.twig', [
            'member' => $member,
            'form' => $form->createView()
        ]);
    }
}
