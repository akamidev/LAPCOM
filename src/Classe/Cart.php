<?php

namespace App\Classe;

use Symfony\Component\HttpFoundation\RequestStack;


class Cart
{

    public function __construct(private RequestStack $requestStack)
    {
    }
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
public function decrease($id)
    {
    
    
        $cart = $this->requestStack->getSession()->get('cart');

       
            if ($cart[$id]['qty'] > 1) {
                $cart[$id]['qty'] = $cart[$id]['qty'] -1;
            } else {
                unset($cart[$id]);
            }
            $this->requestStack->getSession()->set('cart', $cart);
        

    }
    public function remove()
    {
        return $this->requestStack->getSession()->remove('cart');
    }  

    public function getCart()
    {
        return $this->requestStack->getSession()->get('cart');
    }
}
