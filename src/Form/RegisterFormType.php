<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class RegisterFormType extends AbstractType {
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            ->add('username', null, [
                'label' => "Nom d'utilisateur", 
                'constraints' => [
                    new NotBlank([
                        'message' => "Veuillez entrer un nom d'utilisateur", 
                    ]), 
                ], 
            ])
            ->add('email', null, [
                'label' => "Adresse e-mail", 
                'constraints' => [
                    new NotBlank([
                        'message' => "Veuillez entrer un e-mail", 
                    ]), 
                ], 
            ])
            ->add('plainPassword', PasswordType::class, [
                'label' => "Mot de passe", 
                'mapped' => false, 
                'attr' => ['autocomplete' => 'new-password'], 
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez entrer un mot de passe', 
                    ]), 
                    new Length([
                        // max length allowed by Symfony for security reasons
                        'max' => 4096, 
                    ]), 
                ], 
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
