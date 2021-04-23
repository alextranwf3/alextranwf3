<?php

namespace App\Controller\Membre;

use App\Entity\Hotel;
use App\Entity\Reservation;
use App\Repository\HotelRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Dompdf\Dompdf;
use Dompdf\Options;

class FactureController extends AbstractController
{
    /**
     * @Route("/facture/{id}", name="facture")
     */
    public function index(Reservation $reservation): Response
    {
  
    

        return $this->render('facture/index.html.twig', [
            'reservation' => $reservation,
        ]);
    }



    /**
     * @Route("/pdf/{id}", name="pdf")
     */
    public function PDF(Reservation $reservation)
        {
        // Configure Dompdf according to your needs
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');

        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);

        // Retrieve the HTML generated in our twig file
        $html = $this->renderView('facture/pdf.html.twig', [
            'title' => "Voici votre facture.",
            'reservation' => $reservation 
        ]);

        // Load HTML to Dompdf
        $dompdf->loadHtml($html);

    

        // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
        $dompdf->setPaper('A3', 'paysage');

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser (inline view)
        $dompdf->stream("facture.pdf", [
            "Attachment" => false
        ]);
        die();
    }
    


}
