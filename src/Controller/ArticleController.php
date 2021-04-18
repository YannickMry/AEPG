<?php

namespace App\Controller;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends AbstractController
{
    /**
     * @Route("/actualités", name="article_index", methods="GET")
     */
    public function index(ArticleRepository $articleRepository): Response
    {

        return $this->render('article/index.html.twig', [
            'articles' => $articleRepository->findBy(['isHidden' => false], ['createdAt' => 'DESC']),
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
