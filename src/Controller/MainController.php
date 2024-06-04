<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * @Route("/politique-de-confidentialite", name="privacy_policy")
     */
    public function privacyPolicy(): Response
    {
        return $this->render('main/privacy_policy.html.twig');
    }

    /**
     * @Route("/gestion-du-consentement", name="consent_management")
     */
    public function consentManagement(): Response
    {
        return $this->render('main/consent_management.html.twig');
    }

    /**
     * @Route("/conditions-generales-de-vente", name="terms_of_service")
     */
    public function termsOfService(): Response
    {
        return $this->render('main/terms_of_service.html.twig');
    }

    /**
     * @Route("/conditions-generales-dutilisation", name="terms_of_use")
     */
    public function termsOfUse(): Response
    {
        return $this->render('main/terms_of_use.html.twig');
    }
}
