<?php

namespace App\Controller;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends AbstractController
{
    /**
     * @Route("/actualités", name="article_index", methods="GET")
     */
    public function index(ArticleRepository $articleRepository, Request $request): Response
    {
        $currentPage = $request->query->getInt('page', 1);

        $articles = $articleRepository->getPaginatedArticle($currentPage, 6, true);
        $lastpage = ceil($articles->count() / 6);

        return $this->render('article/index.html.twig', [
            'articles' => $articles,
            'lastpage' => $lastpage,
        ]);
    }

    /**
     * @Route("/actualités/{slug}", name="article_show", methods="GET")
     */
    public function show(Article $article): Response
    {

        return $this->render('article/show.html.twig', [
            'article' => $article,
        ]);
    }
}
