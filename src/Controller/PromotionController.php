<?php

namespace App\Controller;

use App\Repository\PromotionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PromotionController extends AbstractController
{
    /**
     * @Route("/promotion", name="promotion_index")
     */
    public function index(PromotionRepository $promotionRepository): Response
    {
        return $this->render('promotion/index.html.twig',[
            'promotions' => $promotionRepository->findBy([], ['year' => 'DESC']),
        ]);
    }
}
