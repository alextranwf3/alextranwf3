<?php

namespace App\Controller\Admin;

use App\Entity\Commentaire;
use App\Entity\User;
use App\Repository\CommentaireRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Request;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="admin")
     * @IsGranted("ROLE_ADMIN")
     */
    public function index(): Response
    {
        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }
    /**
     * @Route("/admin/crud_membre/liste_membre", name="liste_membre")
     * @IsGranted("ROLE_ADMIN")
     */
    public function listemembre(UserRepository $userRepository): Response
    {   
        $users = $userRepository->findAll();
                 
        return $this->render('admin/crud_membre/liste_membre.html.twig', [
            'users' => $users,
        ]);
    }
    /**
     * @Route("/admin/crud_membre/liste_membre/{id}", name="admin_membre_delete")
     * @IsGranted("ROLE_ADMIN")
     */
   public function delete_user(User $user): Response
   {    
       $em = $this->getDoctrine()->getManager();
       
       $em->remove($user);
       
       $em->flush();
       // flash et redirection
       $this->addFlash('success',"L'utilisateur à bien été supprimé.");
       return $this->redirectToRoute('liste_membre');
   }
       
    /**
     * @Route("/admin/crud_membre/liste_commentaire", name="liste_commentaire")
     * @IsGranted("ROLE_ADMIN")
     */
    public function listeCommentaires(CommentaireRepository $commentaireRepository): Response
    {   
        $commentaire = $commentaireRepository->findAll();
                 
        return $this->render('admin/listing_commentaires.html.twig', [
            'commentaire' => $commentaire,
        ]);
    }

    /**
     * @Route("/admin/crud_membre/liste_commentaire/{id}", name="admin_commentaire_delete")
     * @IsGranted("ROLE_ADMIN")
     */
   public function delete_comment(Commentaire $commentaire): Response
   {    
       $em = $this->getDoctrine()->getManager();
       
       $em->remove($commentaire);
       
       $em->flush();
       // flash et redirection
       $this->addFlash('success',"Le commentaire a bien été supprimé.");
       return $this->redirectToRoute('liste_commentaire');
   }
    
}
