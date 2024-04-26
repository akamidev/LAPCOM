<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CategoryController extends AbstractController
{
    #[Route('/categorie/{slug}', name: 'app_category')]
    public function index($slug, CategoryRepository $CategoryRepository): Response
    {

        $category = $CategoryRepository->findOneBySlug($slug);

        if (!$category) {

            return $this->redirectToRoute('app_home');
        }


        return $this->render('category/index.html.twig', [
            'category' => $category,
        ]);
    }
}
