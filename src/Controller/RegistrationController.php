<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Repository\UserRepository;
use App\Security\UserCheckAuthenticator;
use App\Service\EmailService;
use Nzo\UrlEncryptorBundle\Encryptor\Encryptor;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;

class RegistrationController extends AbstractController
{
    /**
     * @Route("/inscription", name="app_register")
     */
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder, EmailService $emailService): Response
    {

        if ($this->getUser()) {
            return $this->redirectToRoute('redirect-user');
        }
        
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $form->get('password')->getData()
                )
            );
            $user->setRoles(['ROLE_MEMBER']);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            // generate a signed url and email it to the user
            $emailService->send([
                'to' =>$user->getEmail(),
                'subject' => "Validez votre inscription",
                'template' => "registration/confirmation_email.html.twig",
                'context' => [
                    'user' => $user
                ],
            ]);
            // do anything else you need here, like send an email
            $this->addFlash('success', 'Merci de vérifier votre compte en cliquant sur le lien dans votre email que nous vous avons envoyé.');
            return $this->redirectToRoute('app_login');
            
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }

    /**
     * @Route("/verify-email/{token}", name="app_verify_email")
     */
    public function verifyUserEmail(
        string $token,
        Encryptor $encryptor,
        UserRepository $userRepository,
        GuardAuthenticatorHandler $guardHandler,
        UserCheckAuthenticator $userCheckAuthenticator,
        Request $request): Response
    {
        $id = $encryptor->decrypt($token);
        $user = $userRepository->find($id);

        if(!$user) {
            throw $this->createNotFoundException("Votre compte est introuvable.");
        }

        $user->setIsVerified(true);
        $em = $this->getDoctrine()->getManager();
        $em->flush();

        return $guardHandler->authenticateUserAndHandleSuccess(
            $user,
            $request,
            $userCheckAuthenticator,
            'main' // firewall name in security.yaml
        );
    }


}
