<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class ResetPasswordFormType extends AbstractType {
    public function buildForm(FormBuilderInterface $builder, array $options): void {
        $builder
            ->add('plainPassword', PasswordType::class, [
                'label' => "form.reset-password.password.label", 
                'constraints' => [
                    new NotBlank([
                        'message' => 'form.reset-password.password.not-blank', 
                    ]), 
                    new Length([
                        // max length allowed by Symfony for security reasons
                        'max' => 4096, 
                    ]), 
                ], 
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void {
        $resolver->setDefaults([]);
    }
}
