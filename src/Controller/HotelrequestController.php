<?php

namespace App\Controller;

use App\Entity\Commentaire;
use App\Entity\Hotel;
use App\Entity\SearchData;
use App\Form\CommentaireType;
use App\Form\SearchFormType;
use App\Repository\CommentaireRepository;
use App\Repository\HotelRepository;
use DateTime;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HotelrequestController extends AbstractController
{
    /**
     * @Route("/request", name="hotelrequest")
     */
    public function Search(HotelRepository $hotelRepository, Request $request,PaginatorInterface $paginator): Response
    {
        $data = new SearchData();
       
        $form = $this->createForm(SearchFormType::class, $data);
        $form->handleRequest($request);
        
        $hotels = $paginator->paginate(
            $hotelRepository->findSearch($data),
                   $request->query->getInt('page', 1),
                   6 );
                   
        return $this->render('hotelrequest/liste_hotel_requete.html.twig', [
            'hotels' => $hotels,
            'form'=>$form->createView()
        ]);
    }

    /**
     * @Route("/request_hotel/details/{id}", name="hotel_details")
     */
    public function hotelDetails(Hotel $hotel): Response
    {
        return $this->render('hotelrequest/hotel_requete_details.html.twig', [
            'hotel' => $hotel,
        ]);
    }

    /**
     * @Route("/request_hotel/details/avis/{id}", name="hotel_avis")
     */
    public function avisHotel(Hotel $hotel, Request $request): Response
    {
        $commentaire = new Commentaire();
        $form = $this->createForm(CommentaireType::class, $commentaire);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $commentaire->setHotel($hotel);
            $commentaire->setUser($this->getUser());
            $commentaire->setCreatedAt(new DateTime());

            $em= $this->getDoctrine()->getManager();
            $em->persist($commentaire);
            $em->flush();

            $this->addFlash('success', 'Merci pour votre commentaire');
            return $this->redirectToRoute('hotel_details', ['id' => $hotel->getId()]);
        }

        return $this->render('hotelrequest/avis_hotel.html.twig', [
            'hotel' => $hotel,
            'form' =>$form->createView(),
        ]);
    }



}