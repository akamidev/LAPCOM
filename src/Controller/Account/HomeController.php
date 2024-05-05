<?php

namespace App\Controller\Account;


use App\Repository\OrderRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class HomeController extends AbstractController
{
   

    #[Route('/compte', name: 'app_account')]
    public function index(OrderRepository $orderRepository): Response
    {
        
        $orders = $orderRepository->findBy([
        
           'user' => $this->getUser(),
           'state'=> [2,3]
        ]);
        // dd($orders);
        return $this->render('account/index.html.twig',[

            'orders' => $orders
        ]);
    }

    
  

  
    
}
