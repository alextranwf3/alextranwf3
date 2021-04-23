<?php

namespace App\Controller;

use App\Entity\Hotel;
use App\Entity\Newsletter;
use App\Form\NewsletterType;
use App\Repository\HotelRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BaseController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(HotelRepository $hotelRepository): Response
    {
        $hotels = $hotelRepository->findPromoHotel(1);

        return $this->render('base/acceuil.html.twig', [
            'hotels' => $hotels,
        ]);
    }

    public function header(string $routeName) {

        return $this->render('base/_header.html.twig', [
            'route_name' => $routeName,
            
        ]);
    }
    public function footer(string $routeName) {
        $form = $this->createForm(NewsletterType::class);
        return $this->render('base/_footer.html.twig', [
            'route_name' => $routeName,
            'form' => $form->createView(),
        ]);
    }


    /**
     * @Route("/redirect-user", name="redirect-user")
     */
    public function redirectUser(): Response
    {
        if ($this->isGranted('ROLE_ADMIN')) {
            return $this->redirectToRoute('admin');
        } elseif ($this->isGranted('ROLE_MEMBER')) {
            return $this->redirectToRoute('membre');
        } else {
            return $this->redirectToRoute('home');
        }
    }
    /**
     * @Route("/newsletter", name="newsletter")
     */
    public function newsletter(Request $request): Response
    {
        $newsletter = new Newsletter();
        $form = $this->createForm(NewsletterType::class, $newsletter);
        $form->handleRequest($request);
       
        if ($form->isSubmitted() && $form->isValid()) {
            //  dd($form);
            $em = $this->getDoctrine()->getManager();
            $em->persist($newsletter);
            $em->flush();
        
            $this->addFlash('success', " vous êtes inscrit a notre Newsletter ");
            return $this->redirectToRoute('home');
        } 
        return $this->render('base/newsletter.html.twig', [
            'form' => $form->createView(),
            
        ]); 

        
    }  
}
