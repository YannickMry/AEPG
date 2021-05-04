<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Form\UserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @IsGranted("ROLE_ADMIN")
 * @Route("/admin", name="admin_user_")
 */
class AdminUserController extends AbstractController
{
    /**
     * @IsGranted("ROLE_SUPERADMIN")
     * @Route("/utilisateur", name="index", methods="GET")
     */
    public function index(): Response
    {
        $users = $this->getDoctrine()->getRepository(User::class)->findBy([], [
            'lastname'  => 'ASC',
            'firstname' => 'ASC'
        ]);
        
        return $this->render('admin/user/index.html.twig', [
            'users' => $users
        ]);
    }

    /**
     * @IsGranted("ROLE_SUPERADMIN")
     * @Route("/utilisateur/creation", name="create", methods="GET")
     */
    public function create(Request $request, EntityManagerInterface $em): Response
    {
        $user = new User();

        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($user);
            $em->flush();
            $this->addFlash('success', "L'utilisateur {$user->getFullName()} a bien été créé !");
            return $this->redirectToRoute('admin_user_index');
        }

        return $this->render('admin/user/create.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @IsGranted("ROLE_SUPERADMIN")
     * @Route("/utilisateur/{id}/modification", name="edit", methods="GET|POST")
     *
     * @param User $user
     * @param Request $request
     * @return Response
     */
    public function edit(User $user, Request $request): Response
    {
        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('success', "L'utilisateur {$user->getFullName()} a bien été modifié !");
            return $this->redirectToRoute('admin_user_index');
        }
        return $this->render('admin/user/edit.html.twig', [
            'form' => $form->createView(),
            'user' => $user
        ]);
    }
}
