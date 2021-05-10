<?php

namespace App\Controller\Admin;

use App\Entity\Article;
use App\Form\ArticleType;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/actualités", name="admin_article_")
 */
class AdminArticleController extends AbstractController
{
    /**
     * @Route("/", name="index", methods="GET")
     */
    public function index(ArticleRepository $articleRepository): Response
    {

        return $this->render('admin/article/index.html.twig', [
            'articles' => $articleRepository->findBy([], ['createdAt' => 'DESC']),
        ]);
    }

    /**
     * @Route("/creation", name="create", methods="GET|POST")
     */
    public function create(Request $request, EntityManagerInterface $em): Response
    {
        $article = new Article();

        $form = $this->createForm(ArticleType::class, $article);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($article);
            $em->flush();
            $this->addFlash(
                'success',
                "L'article '{$article->getTitle()}' a bien été créé"
            );

            return $this->redirectToRoute('admin_article_show', ['slug' => $article->getSlug()]);
        }

        return $this->render('admin/article/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{slug}", name="show", methods="GET")
     */
    public function show(Article $article): Response
    {

        return $this->render('admin/article/show.html.twig', [
            'article' => $article,
        ]);
    }

    /**
     * @Route("/{slug}/modification", name="edit", methods="GET|POST")
     */
    public function edit(Article $article, Request $request, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(ArticleType::class, $article);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();
            $this->addFlash(
                'success',
                "L'article '{$article->getTitle()}' a bien été modifié"
            );

            return $this->redirectToRoute('admin_article_show', ['slug' => $article->getSlug()]);
        }

        return $this->render('admin/article/edit.html.twig', [
            'form' => $form->createView(),
            'article' => $article,
        ]);
    }

    /**
     * @Route("/{slug}/delete", name="delete", methods="DELETE")
     */
    public function delete(Article $article, Request $request, EntityManagerInterface $em): Response
    {
        if ($this->isCsrfTokenValid('article_deletion_' . $article->getId(), $request->request->get('csrf_token'))) {
            $em->remove($article);
            $em->flush();
            $this->addFlash('success', "L'article a bien été supprimé !");
        } else {
            $this->addFlash('danger', "L'article n'a pas pu être supprimé !");
        }
        return $this->redirectToRoute('admin_article_index');
    }
}
