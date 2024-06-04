<?php

// src/Form/ConsentType.php
namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ConsentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('analyticsCookies', CheckboxType::class, [
                'label' => 'Cookies d\'Analyse',
                'required' => false,
            ])
            ->add('marketingCookies', CheckboxType::class, [
                'label' => 'Cookies de Marketing',
                'required' => false,
            ])
            ->add('emailMarketing', CheckboxType::class, [
                'label' => 'Recevoir des emails marketing',
                'required' => false,
            ])
            ->add('smsMarketing', CheckboxType::class, [
                'label' => 'Recevoir des SMS marketing',
                'required' => false,
            ])
            ->add('dataSharing', CheckboxType::class, [
                'label' => 'Permettre le partage de mes données avec des partenaires',
                'required' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
