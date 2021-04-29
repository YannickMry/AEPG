<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Contact;
use App\Form\ContactType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(): Response
    {
        $articles = $this->getDoctrine()->getRepository(Article::class)->findBy([], ['createdAt' => 'DESC'], 3, 0);
        return $this->render('home/index.html.twig', [
            'articles' => $articles,
        ]);
    }

    /**
     * @Route("/contact", name="contact")
     */
    public function contact(Request $request, MailerInterface $mailer): Response
    {
        $contact = new Contact();

        $form = $this->createForm(ContactType::class, $contact);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            /** @var Contact $contact */
            $contact = $form->getData();

            $email = (new Email())
                ->from(new Address($contact->getEmail(), $contact->getName()))
                ->to('noreply@aepg.fr')
                ->subject($contact->getSubject())
                ->text($contact->getContent());

            $mailer->send($email);

            $this->addFlash('success', "Votre message a bien été envoyé !");
            return $this->redirectToRoute('contact');
        }

        return $this->render('home/contact.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
