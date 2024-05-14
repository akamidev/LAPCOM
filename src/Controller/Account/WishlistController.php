<?php

namespace App\Controller\Account;

use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class WishlistController extends AbstractController
{
    #[Route('/compte/liste-de-souhait', name: 'app_account_wishlist')]
    public function index(): Response
    {
        return $this->render('account/wishlist/index.html.twig');
    }
    #[Route('/compte/liste-de-souhait/add/{id}', name: 'app_account_wishlist_add')]
    public function add (ProductRepository $productRepository, EntityManagerInterface $entityManager, Request $request, $id): Response
    {
       //1. Récuperer l'objet produit souhaité pour l'ajouter à la liste de souhait

       $product = $productRepository->findOneById($id);
       //2. si produit existant , ajouter le produit à la liste de souhait
         if ($product) {
              $this->getUser()->addWishlist($product);
              $entityManager->flush();

             
         }
         $this->addFlash(
            'success',
            'Le produit a été ajouté à votre liste de souhait'
        );

        return $this->redirect($request->headers->get('referer'));
    }

    #[Route('/compte/liste-de-souhait/remove/{id}', name: 'app_account_wishlist_remove')]
    public function remove (ProductRepository $productRepository, EntityManagerInterface $entityManager,Request $request, $id): Response
    {
       //1. Récuperer l'objet produit souhaité pour le supprimer à la liste de souhait

       $product = $productRepository->findOneById($id);
       //2. si produit existant , supprimer le produit à la liste de souhait
         if ($product) {

              $this->addFlash('success', 'Le produit a été supprimé de votre liste de souhait');
              $this->getUser()->removeWishlist($product);
              $entityManager->flush();

             
         }
         else {
            $this->addFlash('danger', 'Le produit n\'existe pas dans votre liste de souhait');
         }
         return $this->redirect($request->headers->get('referer'));
    }
}
