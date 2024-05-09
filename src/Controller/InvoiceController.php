<?php

namespace App\Controller;

use App\Repository\OrderRepository;
use Dompdf\Dompdf;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class InvoiceController extends AbstractController
{
    
// Impression de la facture en PDF pour un utilisateur connecté
// verification de la commande pour un utilisateur donner
    #[Route('/compte/facture/impression/{id_order}', name: 'app_invoice_customer')]
    public function printForCustomer(OrderRepository $orderRepository, $id_order): Response
    {     
// instantiate and use the dompdf class

//1. verification de l'objet commande - si existe ?
$order = $orderRepository->findOneById($id_order);

if (!$order) {
    return $this->redirectToRoute('app_account');
}

//2. verification de l'utilisateur connecté - existe

if ($order->getUser() != $this->getUser()) {
    return $this->redirectToRoute('app_account');
}
$dompdf = new Dompdf();

$html = $this->renderView('invoice/index.html.twig',[

    'order' => $order
]);

$dompdf->loadHtml($html);

// (Optional) Setup the paper size and orientation
$dompdf->setPaper('A4', 'portrait');

// Render the HTML as PDF
$dompdf->render();

// Output the generated PDF to Browser
$dompdf->stream('facture.pdf', [

    'Attachements' => false,
]);

       exit();
        
       
    }

    
    
// Impression de la facture en PDF pour un administrateur connecté
// verification de la commande pour un administrateur donner
#[Route('/admin/facture/impression/{id_order}', name: 'app_invoice_admin')]
public function printForAdmin(OrderRepository $orderRepository, $id_order): Response
{     
// instantiate and use the dompdf class

//1. verification de l'objet commande - si existe ?
$order = $orderRepository->findOneById($id_order);

if (!$order) {
return $this->redirectToRoute('admin');
}


$dompdf = new Dompdf();

$html = $this->renderView('invoice/index.html.twig',[

'order' => $order
]);

$dompdf->loadHtml($html);

// (Optional) Setup the paper size and orientation
$dompdf->setPaper('A4', 'portrait');

// Render the HTML as PDF
$dompdf->render();

// Output the generated PDF to Browser
$dompdf->stream('facture.pdf', [

'Attachements' => false,
]);

   exit();
    
   
}
}
