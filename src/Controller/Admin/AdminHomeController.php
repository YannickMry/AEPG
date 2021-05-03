<?php

namespace App\Controller\Admin;

use App\Repository\ArticleRepository;
use App\Repository\PromotionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminHomeController extends AbstractController
{
    /**
     * @Route("/admin", name="admin_home")
     */
    public function index(ArticleRepository $articleRepository, PromotionRepository $promotionRepository, Request $request): Response
    {
        $currentPage = $request->query->getInt('page', 1);

        $articles = $articleRepository->getPaginatedArticle($currentPage, 6);
        $lastpage = ceil($articles->count() / 6);

        return $this->render('admin/home/index.html.twig', [
            'articles'      => $articles,
            'lastpage'      => $lastpage,
            'route'         => 'admin_home',
            'promotions'    => $promotionRepository->findBy([], ['year' => 'DESC']),
        ]);
    }
}
