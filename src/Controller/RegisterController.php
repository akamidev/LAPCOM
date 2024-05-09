<?php

namespace App\Controller;

use App\Classe\Mail;
use App\Entity\User;
use App\Form\RegisterUserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class RegisterController extends AbstractController
{
    #[Route('/inscription', name: 'app_register')]
    public function index(Request $request, EntityManagerInterface $entityManager): Response // returns a Response object
    {
        $user = new User();

        $form =
            $this->createForm(RegisterUserType::class, $user);

        $form->handleRequest($request); // ecouter = handleRequest permet de récupérer les données du formulaire

        if ($form->isSubmitted() && $form->isValid()) {
            // dd($user); // return les datas du formulaire
            // dd($form->getData()); // return les datas du formulaire


            $entityManager->persist($user); // figer les données
            $entityManager->flush(); // enregistrer les données en BDD
            $this->addFlash(
                'success',
                'Votre compte a bien été créé, veuillez vous connecter.'
            );
//envoie d'un email de confirmation pour l'inscription
            $mail = new Mail();
            $vars = [

                'firstname' => $user->getFirstname()
            ];
            $content = 'Bonjour, voici un email de test';
            $mail->send($user->getEmail(), $user->getFirstname().' '.$user->getFirstname(), 'Bienvenue sur votre plateform LAPCOM ', "welcome.html", $vars );
    
    

            return $this->redirectToRoute('app_login');
        }
        // si le formulaire est soumis alors tu enregistre les datas en BDD et tu envoie un messge de confirmation

        return $this->render('register/index.html.twig', [
            'registerForm' => $form->createView(),
        ]);
    }
}
