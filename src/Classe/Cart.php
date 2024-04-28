<?php

namespace App\Classe;

use Symfony\Component\HttpFoundation\RequestStack;


class Cart
{



    public function __construct(private RequestStack $requestStack)
    {
    }

        // fonction pour ajouter un produit au panier
    public function add($product)
    {
        
        $cart = $this->requestStack->getSession()->get('cart', []);

        if (isset($cart[$product->getId()])) {
            $cart[$product->getId()]['qty'] += 1;
        } else {
            $cart[$product->getId()] = [
                'object' => $product,
                'qty' => 1
            ];
        }

        $this->requestStack->getSession()->set('cart', $cart);
    }
    //    // fonction pour supprimer un produit au panier
    public function decrease($id)
    {


        $cart = $this->requestStack->getSession()->get('cart');


        if ($cart[$id]['qty'] > 1) {
            $cart[$id]['qty'] = $cart[$id]['qty'] - 1;
        } else {
            unset($cart[$id]);
        }
        $this->requestStack->getSession()->set('cart', $cart);
    }

     // fonction pour calculer la quantité total des produits dans le panier

    public function fullQuantity()
    {
        $cart = $this->requestStack->getSession()->get('cart');

        if ($cart === null) {
            $cart = [];
        }

        $quantity = 0;
        foreach ($cart as $product) {
            $quantity = $quantity + $product['qty'];
        }

        return $quantity;
    }
// fonction pour calculer le prix total des produits dans le panier
    public function getTotalWt()
    {
        $cart = $this->requestStack->getSession()->get('cart');

        if ($cart === null) {
            $cart = [];
        }

        $price = 0;
        foreach ($cart as $product) {
            $price = $price + ($product['object']->getPriceWt() * $product['qty']);
        }

        return $price;
    }

// fonction pour vider le panier
    public function remove()
    {
        return $this->requestStack->getSession()->remove('cart');
    }
// fonction pour récupérer le panier
    public function getCart()
    {
        return $this->requestStack->getSession()->get('cart');
    }
}
