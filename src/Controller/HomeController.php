<?php
namespace App\Controller;

use App\Classe\Mail;
use App\Form\SearchType;
use App\Repository\HeaderRepository;
use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(Request $request, HeaderRepository $headerRepository, ProductRepository $productRepository): Response
    { 
        $form = $this->createForm(SearchType::class);
        $form->handleRequest($request);
        

        $products = [];

        if ($form->isSubmitted() && $form->isValid()) {
            $query = $form->get('query')->getData();
            $products = $productRepository->findByName($query);
        }
        $searchPerformed = $form->isSubmitted() && $form->isValid();
        return $this->render('home/index.html.twig',[
            'form' => $form->createView(),
            'products' => $products,
            'headers' => $headerRepository->findAll(),
            'productsInHomepage' => $productRepository->findByIsHomepage(true),
            'searchPerformed' => $searchPerformed,
        ]);
    }


}
