<?php

namespace App\Controller\Membre;

use App\Entity\Commentaire;
use App\Entity\User;
use App\Form\CommentaireType;
use App\Form\UserType;
use App\Repository\CommentaireRepository;
use App\Repository\ReservationRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Security\Core\User\UserInterface;

class MembreController extends AbstractController
{
    /**
     * @Route("/membre", name="membre")
     * @IsGranted("ROLE_MEMBER")
     */
    public function displayUser(UserInterface $user, UserRepository $userRepository): Response
    {

        return $this->render('membre/index.html.twig', [
            'controller_name' => 'MembreController',
        ]);
    }

    /**
     * @Route("/membre/coordonnees", name="coordonnees")
     * @IsGranted("ROLE_MEMBER")
     */
    public function displayUserAndModify(UserInterface $user, UserRepository $userRepository): Response
    {
        $member = $userRepository->find($user->getId());
        return $this->render('membre/membreCoordonnees.html.twig', [
            'controller_name' => 'MembreController',
            'user' => $member,
        ]);
    }

    /**
     * @Route("/membre/coordonnees/{id}", name="membre_modification")
     * @IsGranted("ROLE_MEMBER")
     */
    public function modifyUserInfos(User $user, Request $request) {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $user->getPassword();
            $user->getRoles();
            $user->isVerified();

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            $this->addFlash('success', 'Votre compte a été modifié');
            return $this->redirectToRoute('coordonnees', ['id' => $user->getId()]);
        }

        return $this->render('membre/miniForm.html.twig', [
            'form' =>$form->createView(),
            'user' => $user,
        ]);
    }

    /**
     * @Route("/membre/delete/{id}", name="membre_supprimer")
     * @IsGranted("ROLE_MEMBER")
     */
    public function delete(User $user) {

        $session = new Session();
        $session->invalidate();

        $em = $this->getDoctrine()->getManager();
        $em->remove($user);
        $em->flush();

        return $this->redirectToRoute('app_login');
    }

    /**
     * @Route("/membre/listing-reservation", name="listing")
     * @IsGranted("ROLE_MEMBER")
     */
    public function listingReservation(ReservationRepository $reservationRepository) {

        $listing = $reservationRepository->findUserComments($this->getUser());
        // dd($listing);
        return $this->render('membre/reservationListing.html.twig', [
            'listing' => $listing,
        ]);
    }

    /**
     * @Route("/membre/listing-avis", name="listingAvis")
     * @IsGranted("ROLE_MEMBER")
     */
    public function listingAvis(CommentaireRepository $commentaireRepository) {

        $listing = $commentaireRepository->findUserComments($this->getUser());
        return $this->render('membre/avisListing.html.twig', [
            'listing' => $listing,
        ]);
    }
    
    /**
     * @Route("/membre/listing-avis/{id}", name="avis_modification")
     * @IsGranted("ROLE_MEMBER")
     */
    public function modifyUserReview(Commentaire $commentaire, Request $request) {
        $form = $this->createForm(CommentaireType::class, $commentaire);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($commentaire);
            $em->flush();

            $this->addFlash('success', 'Votre avis a été modifié');
            return $this->redirectToRoute('listingAvis');
        }

        return $this->render('membre/avisModifier.html.twig', [
            'form' =>$form->createView(),
            'commentaire' => $commentaire,
        ]);
    }



}
