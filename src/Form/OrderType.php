<?php

namespace App\Form;

use App\Entity\Address;
use App\Entity\Carrier;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class OrderType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {           
    
                    
        $builder

            ->add('addresses', EntityType::class, [
                'label' => "Choisissez votre adresse de livraison",
                'required' => true,
                'class' => Address::class,
                'expanded' => true,
                'choices' => $options['addresses'],
                'label_html' => true
            ])

           

            ->add('carriers', EntityType::class, [
                'label' => "Choisissez votre transporteur",
                'required' => true,
                'class' => Carrier::class,
                'expanded' => true,
                'label_html' => true

            ])

            ->add('submit', SubmitType::class, [
                'label' => "Valider ma commande",
                'attr' => [
                    'class' => 'btn btn-success mb-5 w-100'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'addresses' => null
        ]);
    }
}
