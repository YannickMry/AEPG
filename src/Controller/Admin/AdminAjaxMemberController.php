<?php

namespace App\Controller\Admin;

use App\Repository\PromotionRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
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
}
