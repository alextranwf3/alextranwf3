<?php

namespace App\Controller\Membre;

use App\Entity\Hotel;
use App\Entity\Reservation;
use App\Form\ReservationType;
use App\Repository\HotelRepository;
use App\Repository\ReservationRepository;
use App\Repository\VolRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ReservationController extends AbstractController
{
    /**
     * @Route("/reservation/{id}", name="reservation")
     */
    public function reservation(Hotel $hotel, Request $request,ReservationRepository $reservationRepository)
    {

        $reservation = new Reservation();
        $form = $this->createForm(ReservationType::class, $reservation);
        $form->handleRequest($request);

        $getReservation = $hotel->getReservations();
        $getValues = $getReservation->getValues();
        $listing = $reservationRepository->findUserReservation($this->getUser());
        $user = $this->getUser();
   
        if ($form->isSubmitted() && $form->isValid()) {
            $reservation              
                ->setHotel($hotel)
                ->setUser($this->getUser());

            $getHotel = $reservation->getHotel(); 
            $getVols = $getHotel->getVols();
            $getValues = $getVols->getValues();
            $vol = $getValues[0];
            
            if($vol->getVoyageAffaire()){

                if( $vol->getClasseAffaire() < $reservation->getNombrePersonnes()){
                    $this -> addFlash('danger',"Le nombre de place reservé est superieur au nombre de place disponible.");
                    return $this->redirectToRoute('reservation', [ 'id' => $hotel->getId() ]);
                }
            
            }else{

                if( $vol->getClasseEconomique() < $reservation->getNombrePersonnes()){
                    $this -> addFlash('danger',"Le nombre de place reservé est superieur au nombre de place disponible.");
                    return $this->redirectToRoute('reservation', [ 'id' => $hotel->getId() ]);
                }

            }     
            $em = $this->getDoctrine()->getManager();
            $em->persist($reservation);
            $em->flush();

            $this->addFlash('success', "la reservation a été enregistrée ");
            return $this->redirectToRoute('reservation', [ 'id' => $hotel->getId() ]);
        }
        
        return $this->render('reservation/reservation_formule.html.twig', [
            'form'=> $form->createView(),
            'hotel' => $hotel,
            'listing' => $listing,
            'values' => $getValues,
            'user' => $user,
            'reservation' => $reservation,
        ]);
    }

     /**
     * @Route("/reservation/modification/{id}", name="reservation_modification")
     */
    public function update_reservation(Reservation $reservation,Request $request): Response
    {    
        return $this->handleForm($reservation , $request); 
    }
 
    public function handleForm(Reservation $reservation, Request $request)
    {
        $form = $this->createForm(ReservationType::class, $reservation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $hotel = $reservation->getHotel();
            
            $getVols = $hotel->getVols();
            $getValues = $getVols->getValues();
            $vol = $getValues[0];
              
            if($vol->getVoyageAffaire()){

                if( $vol->getClasseAffaire() < $reservation->getNombrePersonnes()){
                    $this -> addFlash('danger',"Le nombre de place reservé est superieur au nombre de place disponible.");
                    return $this->redirectToRoute('reservation_modification', [ 'id' => $reservation->getId() ]);
                }
            
            }else{
                if( $vol->getClasseEconomique() < $reservation->getNombrePersonnes()){
                    $this -> addFlash('danger',"Le nombre de place reservé est superieur au nombre de place disponible.");
                    return $this->redirectToRoute('reservation_modification', [ 'id' => $reservation->getId() ]);
                }

            }  

         $em = $this->getDoctrine()->getManager();
         $em->persist($reservation);
         $em->flush();
            
            $this->addFlash('success', "votre reservation est modifié");
            return $this->redirectToRoute('reservation', [ 'id' => $hotel->getId() ]);
            }
            
            return $this->render('reservation/form_mofidication.html.twig', [
                'reservation' => $reservation,
                'form' => $form->createView(),
            ]);
        }

}