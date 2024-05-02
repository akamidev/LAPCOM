<?php

namespace App\Controller;

use App\Classe\Cart;
use App\Entity\Order;
use App\Form\OrderType;
use App\Entity\OrderDetail;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class OrderController extends AbstractController
{   

    //1er etape du tunnel du d'achat 
    // choix  de l'adresse de livraison  et du transporteur 

    #[Route('/commande/livraison', name: 'app_order')]
    public function index(): Response
    {
        $addresses = $this->getUser()->getAddresses();
 if ( count($addresses) == 0) {

   
    return $this->redirectToRoute('app_account_address_form');
}
        $form = $this->createForm( OrderType::class, null, [
            
            'addresses' =>  $addresses,
            'action' => $this->generateUrl('app_order_summary') 
        ]);

        
        return $this->render('order/index.html.twig', [
            'deliverForm' => $form->createView(),
        ]);
    }

    //2er etape du tunnel du d'achat 
    // recap de la commande d'utilisateur
    //insertion du base de donnée
    //preparation du payement vers stripe

    #[Route('/commande/recapitulatif', name: 'app_order_summary')]
    public function add(Request $request, Cart $cart, EntityManagerInterface $entityManager): Response
    {    

        if ($request->getMethod() != 'POST') {
            $this->addFlash('warning', 'Vous êtes redirigé vers le panier.');
            return $this->redirectToRoute('app_cart');
        }
  $products = $cart->getCart();



        $form = $this->createForm( OrderType::class, null, [
            
            'addresses' =>  $this->getUser()->getAddresses(),
           
        ]);


    
            $form->handleRequest($request);
          

        if ($form->isSubmitted() && $form->isValid()) {
//stocker les infos en BDD


// Création de la chaine adresse

$addressObj = $form->get('addresses')->getData();


$address  = $addressObj->getFirstname().' '.$addressObj->getLastname().'<br/>';
$address .= $addressObj->getAddress().'<br/>';
$address .= $addressObj->getPostal().' '.$addressObj->getCity().'<br/>';
$address .= $addressObj->getCountry().'<br/>';
$address .= $addressObj->getPhone();





          $order = new Order();
          $order->setCreatedAt(new \DateTime());
            $order->setState(1);
            $order->setCarrierName($form->get('carriers')->getData()->getName());
            $order->setCarrierPrice($form->get('carriers')->getData()->getPrice());
            $order->setDelivery($address);
    
foreach ($products as $product) {

   

    $orderDetail = new OrderDetail();
    $orderDetail->setProductName($product['object']->getName());
    $orderDetail->setProductIllustration($product['object']->getIllustration());
    $orderDetail->setProductPrice($product['object']->getPrice());
    $orderDetail->setProductTva($product['object']->getTva());
    $orderDetail->setProductQuantity($product ['qty']);
    $order->addOrderDetail($orderDetail);


}      
    $entityManager->persist($order); 
    $entityManager->flush();

        }
        return $this->render('order/summary.html.twig', [
            'choices' => $form->getData(),
            'cart' => $products,
            'totalWt' =>$cart->getTotalWt(),
        ]);

    }
}
