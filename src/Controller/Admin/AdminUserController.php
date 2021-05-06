<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Form\CreatePasswordType;
use App\Form\UserType;
use App\Repository\UserRepository;
use App\Service\EmailService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * @Route("", name="admin_user_")
 */
class AdminUserController extends AbstractController
{
    /**
     * @Route("/utilisateur/creation-mot-de-passe/{token}", name="create_password", methods="GET|POST")
     *
     * @param Request $request
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @param UserRepository $userRepository
     * @return Response
     */
    public function createPassword(
        string $token,
        Request $request,
        UserPasswordEncoderInterface $passwordEncoder,
        UserRepository $userRepository,
        EntityManagerInterface $em
    ): Response {
        $user = $userRepository->findOneBy(['token' => $token]);
        if (!$user) {
            $this->addFlash('danger', "Vous n'avez pas accès à ce lien.");
            dd('ici');
            return $this->redirectToRoute('contact');
        }

        $form = $this->createForm(CreatePasswordType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $password = $form->getData()['password'];

            $encodedPassword = $passwordEncoder->encodePassword($user, $password);

            $user->setPassword($encodedPassword)
                ->setToken(null);

            $em->flush();

            $this->addFlash('success', "Votre mot de passe a bien été enregistré !");
            return $this->redirectToRoute('app_login');
        }

        return $this->render('admin/user/create_password.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @IsGranted("ROLE_SUPERADMIN")
     * @Route("/admin/utilisateur", name="index", methods="GET")
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
     * @Route("/admin/utilisateur/creation", name="create", methods="GET|POST")
     */
    public function create(Request $request, EmailService $emailService): Response
    {
        $user = new User();

        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $emailService->sendCreateAccount($user);
            $this->addFlash('success', "L'utilisateur {$user->getFullName()} a bien été créé !");
            return $this->redirectToRoute('admin_user_index');
        }

        return $this->render('admin/user/create.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @IsGranted("ROLE_SUPERADMIN")
     * @Route("/admin/utilisateur/{id}/modification", name="edit", methods="GET|POST")
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
