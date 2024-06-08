<?php
namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

class RegisterUserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstname', TextType::class, [
                'label' => 'Votre prénom',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Merci de saisir votre prénom',
                    ]),
                    new Length([
                        'min' => 2,
                        'max' => 40,
                    ]),
                    new Regex([
                        'pattern' => '/^[a-zA-Z]+$/',
                        'message' => 'Le prénom ne doit contenir que des lettres.',
                    ]),
                ],
                'attr' => ['placeholder' => 'Merci de saisir votre prénom']
            ])
            ->add('lastname', TextType::class, [
                'label' => 'Votre nom',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Merci de saisir votre nom',
                    ]),
                    new Length([
                        'min' => 2,
                        'max' => 40,
                    ]),
                    new Regex([
                        'pattern' => '/^[a-zA-Z]+$/',
                        'message' => 'Le nom ne doit contenir que des lettres.',
                    ]),
                ],
                'attr' => ['placeholder' => 'Merci de saisir votre nom']
            ])
            ->add('email', EmailType::class, [
                'label' => 'Votre adresse email',
                'attr' => ['placeholder' => 'Merci de saisir votre adresse email']
            ])
            ->add('plainPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Merci de saisir un mot de passe'
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Votre mot de passe doit contenir au moins {{ limit }} caractères',
                        'max' => 4096,
                    ]),
                ],
                'first_options' => [
                    'label' => 'Votre mot de passe',
                    'attr' => ['placeholder' => 'Merci de saisir votre mot de passe'],
                    'hash_property_path' => 'password',
                ],
                'second_options' => [
                    'label' => 'Confirmer votre mot de passe',
                    'attr' => ['placeholder' => 'Merci de confirmer votre mot de passe'],
                ],
                'mapped' => false,
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'S\'inscrire',
                'attr' => ['class' => 'btn btn-success']
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'constraints' => [
                new UniqueEntity([
                    'fields' => 'email',
                    'message' => 'Un compte est déjà existant avec cette adresse email'
                ]),
            ],
            'data_class' => User::class,
        ]);
    }
}
