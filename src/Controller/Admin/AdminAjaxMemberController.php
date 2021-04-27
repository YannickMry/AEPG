<?php

namespace App\Controller\Admin;

use App\Entity\Member;
use App\Repository\MemberRepository;
use App\Repository\PromotionRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/admin/ajax-member", name="admin_ajax_member_")
 */
class AdminAjaxMemberController extends AbstractController
{
    /**
     * Renvoie le template de la liste des membres d'une promotion
     *
     * @Route("/render-list-of-members", name="render_list", methods="POST")
     */
    public function ajaxShowMembersOfPromotion(Request $request, PromotionRepository $promotionRepository): Response
    {
        $promotion = $promotionRepository->findOneBy(['year' => $request->request->get('year')]);

        if (!$promotion) {
            $promotion = $promotionRepository->findOneBy([], ['year' => 'DESC']);
        }

        return $this->render('admin/ajax/membersList.html.twig', [
            "promotion" => $promotion,
            "members"   => $promotion->getMembers(),
        ]);
    }

    /**
     * Permet de switch la valeur de la propriété IsDisplayed
     *
     * @Route("/switch-is-displayed", name="switch_is_displayed", methods="POST")
     *
     * @param Request $request
     * @param MemberRepository $memberRepository
     * @return JsonResponse
     */
    public function switchPropertyIsDisplayed(Request $request, MemberRepository $memberRepository): JsonResponse
    {
        /** @var Member $member */
        $member = $memberRepository->findOneById($request->request->get('id'));

        if (!$member) {
            return $this->json([
                'status'    => 404,
                'message'   => "Oups... Membre introuvable !"
            ], 404);
        }

        $member->getisDisplayed() ? $member->setisDisplayed(false) : $member->setisDisplayed(true);

        $this->getDoctrine()->getManager()->flush();

        return $this->json(['isDisplayed' => $member->getisDisplayed()], 200);
    }
}
