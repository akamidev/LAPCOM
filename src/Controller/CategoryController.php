<?php


namespace App\Controller;

use App\Repository\CategoryRepository;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends AbstractController
{
    #[Route('/categorie/{slug}', name: 'app_category')]
    public function index($slug, CategoryRepository $categoryRepository, ProductRepository $productRepository): Response
    {
        $category = $categoryRepository->findOneBySlug($slug);
        if (!$category) {
            return $this->redirectToRoute('app_home');
        }

        $products = $productRepository->findBy(['category' => $category]);

        return $this->render('category/index.html.twig', [
            'category' => $category,
            'products' => $products,
        ]);
    }

    #[Route('/navbar', name: 'app_navbar')]
    public function navbar(CategoryRepository $categoryRepository, ProductRepository $productRepository): Response
    {
        $categories = $categoryRepository->findAll();
        $productsByCategory = [];

        foreach ($categories as $category) {
            $productsByCategory[$category->getId()] = $productRepository->findBy(['category' => $category]);
        }

        return $this->render('partials/_navbar.html.twig', [
            'categories' => $categories,
            'productsByCategory' => $productsByCategory,
        ]);
    }
}
