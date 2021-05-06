<?php

namespace App\Controller\Admin;

use App\Entity\User;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/admin/profile", name="admin_profile_")
 */
class AdminProfileController extends AbstractController
{
    /**
     * @Route("", name="index", methods="GET")
     *
     * @return Response
     */
    public function index(): Response
    {
        return $this->render('admin/profile/index.html.twig');
    }
}
