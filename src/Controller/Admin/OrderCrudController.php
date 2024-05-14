<?php

namespace App\Controller\Admin;

use App\Classe\Mail;
use App\Entity\Order;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class OrderCrudController extends AbstractCrudController
{
    private $em;

    public function __construct(EntityManagerInterface $entityManagerInterface)
    {
        $this->em = $entityManagerInterface;
    }

    public static function getEntityFqcn(): string
    {
        return Order::class;
    }


    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Commande')
            ->setEntityLabelInPlural('Commandes');
    }
    public function configureActions(Actions $actions): Actions
    {

        $show = Action::new('Afficher')->linkToCrudAction('show');
        return $actions
            
            ->add(Crud::PAGE_INDEX, $show )
            ->remove(Crud::PAGE_INDEX, Action::NEW)
            ->remove(Crud::PAGE_INDEX, Action::DELETE)
            ->remove(Crud::PAGE_INDEX, Action::EDIT)
        ;
    }
    
    // fonction permettant de changer le statut de la commande
    public function changeState($order, $state)
 
    {
        // 1- Modification de statut de la commande
        $order->setState($state);
        $this->em->flush();
        // 2- Affichage message pour informer l'utilisateur
        $this->addFlash('success', 'Le statut de la commande a bien été modifié');

        // 3- informer l'utilisateur par mail de la modification de statut de la commande

        if ($state == 3) {
            
            $object = "Commande en cours de preparation";

        }  elseif ($state == 4) {
            $object = "Commande livrée";

        } elseif ($state == 5) {
            $object = "Commande annulée";

        }
        $mail = new Mail();
        $vars = [

            'firstname' => $order->getUser()->getFirstname(),
            'id_order' => $order->getId()
        ];
        $content = 'Bonjour, voici un email de test';
        $mail->send ($order->getUser()->getEmail(),  $order->getUser()->getFirstname().' '. $order->getUser()->getLastname(), $object, "order_state_".$state.".html", $vars );




    }


    public function show(AdminContext $context, AdminUrlGenerator $adminUrlGenerator, Request $request)
    {
        $order = $context->getEntity()->getInstance();

        //récupérer l'URL de notre action "show"
        $url = $adminUrlGenerator
        ->setController(self::class)->setAction('show')->setEntityId($order->getId())->generateUrl();

       if($request->get('state')) {

         $this->changeState($order, $request->get('state'));  // Appel de la fonction changeState
       }
      


       
           

// Traitement de changement de statut
return $this->render('admin/order.html.twig', [

    'order' => $order,
    'current_url' => $url

]);
    }
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            DateField::new('createdAt')->setLabel('Date'),
           NumberField::new('state')->setLabel('Statut')->setTemplatePath('admin/state.html.twig'),
            AssociationField ::new('user')->setLabel('Utilisateur'),
            TextField::new('carrierName')->setLabel('Transporteur'),
            NumberField::new('totalTva')->setLabel('Total TVA'),
            NumberField::new('totalWt')->setLabel('Total TTC'),
            
        ];
    }
    
}
