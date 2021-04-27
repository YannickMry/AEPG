<?php

namespace App\Controller\Admin;

use App\Repository\ArticleRepository;
use App\Repository\PromotionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminHomeController extends AbstractController
{
    /**
     * @Route("/admin", name="admin_home")
     */
    public function index(ArticleRepository $articleRepository, PromotionRepository $promotionRepository): Response
    {
        return $this->render('admin/home/index.html.twig', [
            'articles'      => $articleRepository->findBy([], ['createdAt' => 'DESC'], 5),
            'promotions'    => $promotionRepository->findBy([], ['year' => 'DESC']),
        ]);
    }
}
