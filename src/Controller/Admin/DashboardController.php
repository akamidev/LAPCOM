<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Entity\Order;
use App\Entity\Header;
use App\Entity\Carrier;
use App\Entity\Product;
use App\Entity\Category;
use App\Entity\ContactMessage;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
         $url = $this->container->get('router')->generate('app_home');
       
        // Option 1. You can make your dashboard redirect to some common page of your backend

        $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);

        return $this->redirect($adminUrlGenerator->setController(UserCrudController::class)->generateUrl());
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('LapCom');
    }

    public function configureMenuItems(): iterable
    {

        $url = $this->container->get('router')->generate('app_home');

        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToCrud('Utilisateurs', 'fas fa-user', User::class);
        yield MenuItem::linkToCrud('Catégories', 'fas fa-tags', Category::class);
        yield MenuItem::linkToCrud('Produits', 'fas fa-box-open', Product::class);
        yield MenuItem::linkToCrud('Transporteurs', 'fas fa-truck', Carrier::class);
        yield MenuItem::linkToCrud('Commandes', 'fas fa-clipboard-list', Order::class);
        yield MenuItem::linkToCrud('Header', 'fas fa-header', Header::class);
        yield MenuItem::linkToCrud('Messages de Contact', 'fas fa-envelope', ContactMessage::class);
        yield MenuItem::linkToUrl('Page d\'accueil', 'fas fa-arrow-left', $url);
       



    }
}
