<?php

namespace App\Form;

use App\Entity\Trick;
use App\Entity\Category;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class CreateTrickFormType extends AbstractType {
    public function buildForm(FormBuilderInterface $builder, array $options): void {
        $builder
            ->add('name', null, [
                'label' => "form.create-trick.name.label", 
                'constraints' => [
                    new NotBlank([
                        'message' => "form.create-trick.name.not-blank", 
                    ]), 
                ], 
            ])
            ->add('description', null, [
                'label' => "form.create-trick.description.label", 
                'constraints' => [
                    new NotBlank([
                        'message' => "form.create-trick.description.not-blank", 
                    ]), 
                ], 
            ])
            ->add('category', EntityType::class, [
                'label' => "form.create-trick.category.label", 
                'constraints' => [
                    new NotBlank([
                        'message' => "form.create-trick.category.not-blank", 
                    ]), 
                ], 
                'class' => Category::class,
                'choice_label' => 'name',
            ])
            ->add('coverImage', FileType::class, [
                'label' => "form.create-trick.cover-image.label", 
                'attr' => [
                    'accept' => "image/*"
                ],
                'mapped' => false, 
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void {
        $resolver->setDefaults([
            'data_class' => Trick::class,
        ]);
    }
}
