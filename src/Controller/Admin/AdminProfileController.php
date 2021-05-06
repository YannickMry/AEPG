<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Form\ProfileType;
use App\Form\EditPasswordType;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\Id;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * @Route("/admin/profil", name="admin_profile_")
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


    /**
     * @Route("/edit", name="edit", methods="GET|POST")
     *
     * @return Response
     */
    public function edit(
        Request $request,
        EntityManagerInterface $em,
        UserPasswordEncoderInterface $passwordEncoder
    ): Response {

        $formProfile = $this->createForm(ProfileType::class, $this->getUser())->handleRequest($request);
        $formEditPassword = $this->createForm(EditPasswordType::class)->handleRequest($request);

        /** @var User $user */
        $user = $this->getUser();

        if ($formProfile->isSubmitted() && $formProfile->isValid()) {
            $em->flush();
            $this->addFlash('success', "Vos informations ont bien été modifiées !");

            return $this->redirectToRoute('admin_profile_index');
        }

        if ($formEditPassword->isSubmitted() && $formEditPassword->isValid()) {
            $plainPassword = $formEditPassword->getData()['new_password'];

            $user->setPassword($passwordEncoder->encodePassword($user, $plainPassword));

            $em->flush();
            $this->addFlash('success', "Votre mot de passe a bien été modifié !");

            return $this->redirectToRoute('admin_profile_index');
        }

        return $this->render('admin/profile/edit.html.twig', [
            'formProfile' => $formProfile->createView(),
            'formEditPassword' => $formEditPassword->createView(),
        ]);
    }
}
