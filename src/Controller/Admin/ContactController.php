<?php

namespace App\Controller\Admin;

use App\Entity\Contact;
use App\Form\ContactType;
use App\Service\EmailService;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    /**
     * @Route("/contact", name="contact")
     */
    public function index(Request $request, EmailService $emailService): Response
    {
        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $contact->getCreatedAt(new DateTime());
            $em = $this->getDoctrine()->getManager();
            $em->persist($contact);
            $em->flush();

            $sentToAdmin = $emailService->send([
                'replyTo' => $contact->getEmail(),
                'subject' => '[CONTACT] - '. $contact->getSujet(),
                'template' => "email/contact.html.twig",
                'context' => ['contact' => $contact],
            ]);

            $sentToContact = $emailService->send([
                'to' =>$contact->getEmail(),
                'subject' => "Merci de nous avoir contacté",
                'template' => "email/email_confirmation.html.twig",
                'context' => ['contact' => $contact],
            ]);


            if($sentToAdmin && $sentToContact) {
                $this->addFlash('success', 'Votre demande a bien été envoyée.');
                return $this->redirectToRoute('home');
            }else {
                $this->addFlash('danger', 'Une erreur est survenue.');
            }
        }

        return $this->render('contact/index.html.twig', [
            'form' =>$form->createView(),
        ]);
    }

}
