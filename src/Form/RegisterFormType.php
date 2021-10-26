<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class RegisterFormType extends AbstractType {
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            ->add('username', null, [
                'label' => "form.register.username.label", 
                'constraints' => [
                    new NotBlank([
                        'message' => "form.register.username.not-blank", 
                    ]), 
                ], 
            ])
            ->add('email', null, [
                'label' => "form.register.email.label", 
                'constraints' => [
                    new NotBlank([
                        'message' => "form.register.email.not-blank", 
                    ]), 
                    new Length([
                        'max' => 191, 
                        'maxMessage' => "form.register.email.too-long", 
                    ]), 
                ], 
            ])
            ->add('plainPassword', PasswordType::class, [
                'label' => "form.register.password.label", 
                'mapped' => false, 
                'attr' => ['autocomplete' => 'new-password'], 
                'constraints' => [
                    new NotBlank([
                        'message' => 'form.register.email.not-blank', 
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
