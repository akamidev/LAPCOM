<?php

namespace App\Controller;

use Stripe\Stripe;
use App\Classe\Cart;
use Stripe\Checkout\Session;
use App\Repository\OrderRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PaymentController extends AbstractController
{
    #[Route('/commande/paiement/{id_order}', name: 'app_payment')]
    public function index($id_order, OrderRepository $orderRepository, EntityManagerInterface $entityManager ): Response
    {

        
        Stripe::setApiKey($_ENV['STRIPE_SECRET_key']);
       

    
    //  $order = $orderRepository->findOneById($id_order);

     //securisé l url 

     $order = $orderRepository->findOneBy(
        [
            'id' => $id_order,
            'user'=>$this->getUser()


        ]);
        // dd($order);

// si c different id_user rederige vers la page d'accueil


        if(!$order){
            return $this->redirectToRoute('app_home');
        }


     $products_for_stripe = [];


     foreach ($order->getOrderDetails() as $product) {



        $products_for_stripe [] = [


            'price_data' => [

                'currency' => 'eur',
                'unit_amount' => number_format($product->getProductPriceWt() * 100, 0, '', ''),
                'product_data' => [
                    'name' => $product->getProductName(),
                    'images' => [
                        
                        // $YOUR_DOMAIN.'/uploads/'.$product->getProductIllustration()
                        str_replace('[extention]', '.jpg', $_ENV['DOMAIN'].'/uploads/'.$product->getProductIllustration())

                ]
                ]
            ],
            'quantity' => $product->getProductQuantity(),
        ];
     
    // dd($order);
     }

        $products_for_stripe [] = [


            'price_data' => [

                'currency' => 'eur',
                'unit_amount' => number_format($order->getCarrierPrice() * 100, 0, '', ''),
                'product_data' => [
                    'name' => 'Transporteur : ' .$order->getCarrierName(),
                   
                ]
            ],
            'quantity' => 1,
        ];


        $checkout_session = Session::create([

            'customer_email' => $this->getUser()->getEmail(),   //recuperer l'email de l'utilisateur connecté
            'line_items' => [[
          $products_for_stripe
            ]],
            'mode' => 'payment',
            'success_url' =>$_ENV['DOMAIN'] . '/commande/merci/{CHECKOUT_SESSION_ID}',
            'cancel_url' => $_ENV['DOMAIN'] . '/mon-panier/annulation',
        ]);
       
        $order->setStripeSessionId($checkout_session->id); //set id enregistrer dans la base de donnée

        $entityManager->flush();// flush c'est pour  enregistrer dans la base de donnée l'identifiant de session  stripe

        return $this->redirect($checkout_session->url);
    }

    #[Route('/commande/merci/{stripe_session_id}', name: 'app_payment_success')]
    public function success($stripe_session_id, OrderRepository $orderRepository, EntityManagerInterface $entityManager, Cart $cart): Response

    {
     
        $order = $orderRepository->findOneBy([
            'stripe_session_id' => $stripe_session_id,
            'user' =>$this->getUser()
        ]);

        if(!$order){
            return $this->redirectToRoute('app_home');
        }
        
            // dd($order);
        if ($order->getState() == 1){  // si la commande est en cours de traitement (state = 1
            $order->setState(2); // on passe la commande en cours de livraison (state = 2)
            $cart->remove(); // on supprime le panier
            $entityManager->flush(); // on enregistre la modification dans la base de données
        } 
        
            return $this->render('payment/success.html.twig', [
            
                'order'=>$order,
               
                
            ]);
    }
}
