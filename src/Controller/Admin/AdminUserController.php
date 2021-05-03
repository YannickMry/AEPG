<?php

namespace App\Controller\Admin;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/utilisateur", name="admin_user_")
 */
class AdminUserController extends AbstractController
{
    /**
     * @Route("/", name="index")
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
}
