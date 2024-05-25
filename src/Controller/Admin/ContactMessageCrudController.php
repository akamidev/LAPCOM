<?php


namespace App\Controller\Admin;

use App\Entity\ContactMessage;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;

class ContactMessageCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return ContactMessage::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('name', 'Nom')
                ->setHelp('Le nom du client')
                ->setCssClass('fw-bold text-primary'),
            TextField::new('email', 'Email')
                ->setHelp('L\'email du client')
                ->setCssClass('text-info'),
            TextField::new('subject', 'Sujet')
                ->setHelp('Le sujet du message')
                ->setCssClass('fw-bold text-success'),
            TextareaField::new('message', 'Message')
                ->setHelp('Le contenu du message')
                ->setCssClass('text-dark'),
            DateTimeField::new('createdAt', 'Date de réception')
                ->setHelp('La date et l\'heure de réception du message')
                ->setCssClass('text-muted'),
        ];
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->disable(Action::EDIT, Action::NEW)
            ->add(Crud::PAGE_INDEX, Action::DETAIL);
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->overrideTemplates([
                'crud/detail' => 'admin/contact_message/show.html.twig',
            ]);
    }

    
}


