<?php

namespace App\Controller\Admin;

use App\Entity\Hotel;
use App\Entity\Vol;
use App\Form\HotelType;
use App\Form\VolType;
use App\Repository\HotelRepository;
use App\Repository\VolRepository;
use App\Service\UploadService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class VoyageController extends AbstractController
{   
    #---------------------------------------------CRUD vol--------------------------------------------------------

    // #[Route('/admin/crud/liste-vol', name: 'liste_vol')]
    // public function liste_vol(VolRepository $volRepository,Request $request, PaginatorInterface $paginator): Response
    // {
    //     $vols = $paginator->paginate(
    //      $volRepository->findRecentVol(6),
    //             $request->query->getInt('page', 1),
    //             3 );
    //     // $vol =  $volRepository->findRecentvol(12);
    //     return $this->render('admin/crud_voyage/vol/liste_vol.html.twig', [
    //         'vols' => $vols,
    //     ]);
    // }
 
    /**
     * @Route("/admin/crud/add_vol", name="add_vol")
     * @IsGranted("ROLE_ADMIN")
     */
    public function add_vol(Request $request): Response
    {
        $vol = new Vol();
 
        return $this->handleForm2( $vol , $request , true);    
    }

    /**
     * @Route("/admin/crud/modifier_vol/{id}", name="vol_modifier")
     * @IsGranted("ROLE_ADMIN")
     */
    public function update_vol(Vol $vol,Request $request): Response
    {    
        return $this->handleForm2($vol , $request ,false); 
    }
 
    public function handleForm2(Vol $vol, Request $request, bool $new)
    {
        $form = $this->createForm(VolType::class, $vol);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
         $em = $this->getDoctrine()->getManager();
         $em->persist($vol);
         $em->flush();
            
            $this->addFlash('success', "votre vol est" . ($new ? ' ' . ' crée' : ' modifié'));
            return $this->redirectToRoute('vol_modifier', ['id' => $vol->getId()]);
            }
            
            return $this->render('admin/crud_voyage/vol/vol_form.html.twig', [
                'vol'=>$vol,
                'form' => $form->createView(),
                'new' => $new,
            ]);
        }
 
    /**
     * @Route("/admin/crud/delete_vol/{id}", name="vol_delete")
     * @IsGranted("ROLE_ADMIN")
     */
    public function delete_vol(Vol $vol): Response
    {    
        $em = $this->getDoctrine()->getManager();
        $em->remove($vol);
        $em->flush();
        // flash et redirection
        $this->addFlash('success',"Le vol a bien été supprimé.");
        return $this->redirectToRoute('liste_hotel');
    }







   #---------------------------------------------CRUD hotel--------------------------------------------------------

   private $uploadService;

   public function __construct(UploadService $uploadService)
   {
       $this->uploadService = $uploadService;
   }

    /**
     * @Route("/admin/crud/liste-hotel", name="liste_hotel")
     * @IsGranted("ROLE_ADMIN")
     */
   public function liste_hotel(HotelRepository $hotelRepository,Request $request, PaginatorInterface $paginator): Response
   {
       $hotels = $paginator->paginate(
        $hotelRepository->findRecentHotel(6),
               $request->query->getInt('page', 1),
               3 );
             
       // $hotel =  $hotelRepository->findRecenthotel(12);
       return $this->render('admin/crud_voyage/hotel/liste_hotel.html.twig', [
           'hotels' => $hotels,
       ]);
   }

    /**
     * @Route("/admin/crud/add_hotel", name="add_hotel")
     * @IsGranted("ROLE_ADMIN")
     */
   public function add_hotel(Request $request): Response
   {
       $hotel = new Hotel();

       return $this->handleForm( $hotel , $request , true);    
   }

    /**
     * @Route("/admin/crud/modifier_hotel/{id}", name="hotel_modifier")
     * @IsGranted("ROLE_ADMIN")
     */
   public function update_hotel(Hotel $hotel,Request $request): Response
   {    
       return $this->handleForm($hotel , $request ,false); 
   }

   public function handleForm(Hotel $hotel, Request $request, bool $new)
   {
       $form = $this->createForm(HotelType::class, $hotel);
       $form->handleRequest($request);
       
       if ($form->isSubmitted() && $form->isValid()) {
        $image = $form->get('image')->getData();
        if ($image) {
            $fileName = $this->uploadService->uploadImage($image, $hotel);
            $hotel->setImage($fileName);
        }
        $image2 = $form->get('image2')->getData();
        if ($image2) {
            $fileName2 = $this->uploadService->uploadImage($image2, $hotel);
            $hotel->setImage2($fileName2);
        }
        $image3 = $form->get('image3')->getData();
        if ($image3) {
            $fileName3 = $this->uploadService->uploadImage($image3, $hotel);
            $hotel->setImage3($fileName3);
        }
        $image4 = $form->get('image4')->getData();
        if ($image4) {
            $fileName4 = $this->uploadService->uploadImage($image4, $hotel);
            $hotel->setImage4($fileName4);
        }
        $hotel->setImage($fileName);
        $hotel->setImage2($fileName2);
        $hotel->setImage3($fileName3);
        $hotel->setImage4($fileName4);
        $em = $this->getDoctrine()->getManager();
        $em->persist($hotel);
        $em->flush();
           
           $this->addFlash('success', "votre hotel est" . ($new ? ' ' . ' crée' : ' modifié'));
           return $this->redirectToRoute('hotel_modifier', ['id' => $hotel->getId()]);
           }
           
           return $this->render('admin/crud_voyage/hotel/hotel_form.html.twig', [
               'hotel'=>$hotel,
               'form' => $form->createView(),
               'new' => $new,
           ]);
       }

    /**
     * @Route("/admin/crud/delete_hotel/{id}", name="hotel_delete")
     * @IsGranted("ROLE_ADMIN")
     */
   public function delete_hotel(Hotel $Hotel): Response
   {    
       $em = $this->getDoctrine()->getManager();
       $em->remove($Hotel);
       $em->flush();
       // flash et redirection
       $this->addFlash('success',"L'Hôtel a bien été supprimé.");
       return $this->redirectToRoute('liste_hotel');
   }
   

    /**
     * @Route("/admin/crud/liste-hotel/{id}", name="hotel_vol")
     * @IsGranted("ROLE_ADMIN")
     */
    public function article(Hotel $hotel, Request $request): Response
    {
        $vol = new Vol();
        $form = $this->createForm(VolType::class, $vol);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $vol->setHotel($hotel);

            $em = $this->getDoctrine()->getManager();
            $em->persist($vol);
            $em->flush();

            $this->addFlash('success', "vol lié a l'hôtel");
            return $this->redirectToRoute('hotel_vol', [ 'id' => $hotel->getId() ]);
        }

        return $this->render('admin/crud_voyage/hotel/hotel_vol.html.twig', [
            'hotel' => $hotel,
            'form' => $form->createView(),
        ]);
    }
}

