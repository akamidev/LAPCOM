<?php

namespace App\Controller;

use App\Entity\Address;
use App\Form\AddressUserType;
use App\Form\PasswordUserType;
use App\Repository\AddressRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AccountController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
$this->entityManager = $entityManager;
    }

    #[Route('/compte', name: 'app_account')]
    public function index(): Response
    {
        return $this->render('account/index.html.twig');
    }

    
    #[Route('/compte/modifier-mot-de-passe', name: 'app_account_modify_pwd')]
    public function password(Request $request, UserPasswordHasherInterface $passwordHasher): Response
    {   
        

        $user = $this->getUser();
        // dd($user);

        $form = $this->createForm(PasswordUserType::class, $user, [
            'passwordHasher' => $passwordHasher
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
             
            $this->entityManager->flush();
            // $this->addFlash('success', 'Votre mot de passe a bien été modifié');
            // dd($form->getData());
            $this->addFlash('success',
        'Votre mot de passe a bien été modifié.');
        }
        return $this->render('account/password.html.twig', [
            'modifyPwd' => $form->createView(),
        ] );
    }

    #[Route('/compte/adresses', name: 'app_account_addresses')]
    public function addresses(): Response
    {
        return $this->render('account/addresses.html.twig');
    }



    #[Route('/compte/adresses/delete/{id}', name: 'app_account_address_delete')]
    public function addressDelete($id, AddressRepository $addressRepository): Response
    {
        $address = $addressRepository->findOneById($id);

        //si l'adresse n'existe pas  ou si l'utilisateur ne correspond pas tu me redireige vers la page adresse
        if (!$address OR $address->getUser() != $this->getUser())
        {

           return $this->redirectToRoute('app_account_addresses');
        }
        $this->addFlash('success', 'Votre adresse a bien été supprimée');

        $this->entityManager->remove($address); 
        $this->entityManager->flush(); // enregistre la suppression dans la base de donnée

        return $this->redirectToRoute('app_account_addresses');

    }



   
    #[Route('/compte/adresse/ajouter/{id}', name: 'app_account_address_form', defaults: ['id' => null])]
    public function addressForm(Request $request, $id, AddressRepository $addressRepository): Response
    {   
        if ($id) {
            $address = $addressRepository->findOneById($id);
            if (!$address OR $address->getUser() != $this->getUser())
             {

                return $this->redirectToRoute('app_account_addresses');
             }
        } else {
            $address = new Address();
            $address->setUser($this->getUser());
        }
    
        $form = $this->createForm(AddressUserType::class, $address);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($address);
            $this->entityManager->flush();
            $this->addFlash('success', 'Votre adresse a bien été ajoutée');
    
            return $this->redirectToRoute('app_account_addresses');
        }
    
        // Créez le formulaire avec les données de l'adresse après avoir géré la requête du formulaire
        $form = $this->createForm(AddressUserType::class, $address);
    
        return $this->render('account/addressForm.html.twig', [
            'addressForm' => $form->createView(),
        ]);
    }
    
}
