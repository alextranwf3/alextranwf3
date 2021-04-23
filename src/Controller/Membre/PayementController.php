<?php

namespace App\Controller\Membre;

use App\Entity\Payement;
use App\Entity\Reservation;
use App\Entity\Vol;
use App\Form\PayementType;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PayementController extends AbstractController
{
    /**
     * @Route("/payement/{id}", name="payement")
     */
    public function payement(Request $request,Reservation $reservation)
    {
        $payement = new Payement();
       
        $payement->setReservation($reservation);
        $form = $this->createForm(PayementType::class, $payement);
        $form -> handleRequest($request);
      
        if($form -> isSubmitted() && $form -> isValid()){
            $payement
                    ->setPaiementValide(true)
                    ->setDatePaiement(new DateTime())
                    ->setReservation($reservation);
            if($payement->setPaiementValide(true)) {
                $test = $payement->getReservation();
                $test2 = $test->getHotel();
                $test3 = $test2->getVols();
                $test4 = $test3->getValues();
                $vol = $test4[0];
                
                if($vol->getVoyageAffaire()){
                    $vol->setClasseAffaire($vol->getClasseAffaire() - $reservation->getNombrePersonnes());
                    }else{
                    $vol->setClasseEconomique($vol->getClasseEconomique() - $reservation->getNombrePersonnes());
                    }
            }
            
            $em = $this -> getDoctrine() -> getManager();
            $em -> persist($payement);
            $em -> flush();
            $this -> addFlash('success',"Votre paiement est pris en compte.");
        return $this->redirectToRoute('facture', [ 'id' => $reservation->getId() ]);
            
        }

        return $this->render('payement/index.html.twig', [
            'form'=> $form->createView(),
            ]);
    }

    public function index(): Response
    {
        return $this->render('payement/index.html.twig', [
           
        ]);
    }
}
