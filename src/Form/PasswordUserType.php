<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class PasswordUserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('actualPassword', PasswordType::class, [
                'label' => 'Votre mot de passe actuel',
                'attr' => ['placeholder' => 'Merci de saisir votre mot de passe actuel'],
                'mapped' => false, // essaie de ne pas faire le liens entre l'entity et le champs que je te donne
            ])
            // plainPassword sera un champ qui ne sera pas lié à l'entité User
            ->add('plainPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'constraints' => [
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Votre mot de passe doit contenir au moins {{ limit }} caractères',
                        'max' => 4096,
                    ]),
                ],
                'first_options' => [
                    'label' => 'Votre nouveau mot de passe',
                    'attr' => ['placeholder' => 'Merci de saisir votre nouveau mot de passe'],
                    'hash_property_path' => 'password', // permet de hasher le mot de passe
                ],
                'second_options' => [
                    'label' => 'Confirmer votre mot de passe ',
                    'attr' => ['placeholder' => 'Merci de confirmer votre nouveau mot de passe'],
                ],
                'mapped' => false, // essaie de ne pas faire le liens entre l'entity et le champs que je te donne 
            ])



            ->add('submit', SubmitType::class, [
                'label' => 'Mettre à jour mon mot de passe',
                'attr' => ['class' => 'btn btn-success']
            ])
            ->addEventListener(FormEvents::SUBMIT, function (FormEvent $event) {
                $form = $event->getForm();
                $user = $form->getConfig()->getOptions()['data'];
                $passwordHasher = $form->getConfig()->getOptions()['passwordHasher'];
                
                
                // die('Event ok ');
                // 1.Recuperer le mot de passe saisi par l'utilisateur et le comparer au mdp en bdd (dans l'entité User) 
                
                $isValid = $passwordHasher->isPasswordValid(
                    $user,
                    $form->get('actualPassword')->getData()
                );
                // dd($isValid);

                // 3. si c'est != alors on ajoute une erreur
                if (!$isValid) {
                    $form->get('actualPassword')->addError(new FormError('Le mot de passe saisi est incorrect'));
                }
            })
            ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'passwordHasher' => null,
        ]);
    }
}
