<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProductController extends AbstractController
{      
    

    

#[Route('/produit/{slug}', name: 'app_product')]
    public function index($slug, ProductRepository $productRepository): Response
    {   
        $product = $productRepository->findOneBySlug($slug);
        if (!$product) {

            return $this->redirectToRoute('app_home');
        }


        return $this->render('product/index.html.twig', [
            'product' => $product,
        ]);
    }

    public function show($slug, ProductRepository $productRepository): Response
    {
        $product = $productRepository->findOneBy(['slug' => $slug]);

        if (!$product) {
            throw $this->createNotFoundException('Produit non trouvé');
        }

        return $this->render('product/show.html.twig', [
            'product' => $product,
        ]);
    }
}
