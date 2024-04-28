<?php

namespace App\Twig;

use App\Classe\Cart;
use Twig\TwigFilter;
use Twig\Extension\GlobalsInterface;
use Twig\Extension\AbstractExtension;
use App\Repository\CategoryRepository;

class AppExtensions extends AbstractExtension implements GlobalsInterface

{   
    private $cart;
    private $categoryRepository;
    public function __construct(CategoryRepository $categoryRepository, Cart $cart)
    {
        $this->categoryRepository = $categoryRepository;
        $this->cart = $cart;
    }
    public function getFilters()
    {
        return [
            new TwigFilter('price', [$this, 'formatPrice'])
        ];
    }

    public function formatPrice($number)
    {
       
        return number_format($number, 2, ',', ' ') . ' €';
    }

    public function getGlobals(): array
    {
        return [
            'allCategories' => $this->categoryRepository->findAll(),
            'fullCartQuantity' => $this->cart->fullQuantity()
        ];
    }
}