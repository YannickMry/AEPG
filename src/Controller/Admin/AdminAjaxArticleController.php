<?php

namespace App\Controller\Admin;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/admin/ajax-article", name="admin_ajax_article_")
 */
class AdminAjaxArticleController extends AbstractController
{
    /**
     * Permet de switch la valeur de la propriété IsDisplayed
     * 
     * @Route("/switch-is-displayed", name="switch_is_displayed", methods="POST")
     *
     * @param Request $request
     * @param ArticleRepository $articleRepository
     * @return JsonResponse
     */
    public function switchPropertyIsDisplayed(Request $request, ArticleRepository $articleRepository): JsonResponse
    {
        /** @var Article $article */
        $article = $articleRepository->findOneById($request->request->get('id'));

        if (!$article) {
            return $this->json([
                'status'    => 404,
                'message'   => "Oups... Article introuvable !"
            ], 404);
        }

        $article->getisDisplayed() ? $article->setisDisplayed(false) : $article->setisDisplayed(true);

        $this->getDoctrine()->getManager()->flush();

        return $this->json($article, 200);
    }
}
