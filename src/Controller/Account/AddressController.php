<?php

namespace App\Controller\Account;


use App\Entity\Address;
use App\Form\AddressUserType;
use App\Repository\AddressRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AddressController extends AbstractController
{

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }


    #[Route('/compte/adresses', name: 'app_account_addresses')]

    public function index(): Response
    {
        return $this->render('account/address/index.html.twig');
    }



    #[Route('/compte/adresses/delete/{id}', name: 'app_account_address_delete')]

    public function delete($id, AddressRepository $addressRepository): Response
    {
        $address = $addressRepository->findOneById($id);

        //si l'adresse n'existe pas  ou si l'utilisateur ne correspond pas tu me redireige vers la page adresse
        if (!$address or $address->getUser() != $this->getUser()) {

            return $this->redirectToRoute('app_account_addresses');
        }
        $this->addFlash('success', 'Votre adresse a bien été supprimée');

        $this->entityManager->remove($address);
        $this->entityManager->flush(); // enregistre la suppression dans la base de donnée

        return $this->redirectToRoute('app_account_addresses');
    }




    #[Route('/compte/adresse/ajouter/{id}', name: 'app_account_address_form', defaults: ['id' => null])]

    public function form(Request $request, $id, AddressRepository $addressRepository): Response
    {
        if ($id) {
            $address = $addressRepository->findOneById($id);
            if (!$address or $address->getUser() != $this->getUser()) {

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

        return $this->render('account/address/form.html.twig', [
            'addressForm' => $form->createView()
        ]);
    }
}
