<?php

namespace App\Form;

use App\Entity\Trick;
use App\Form\MediaType;
use App\Entity\Category;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class TrickFormType extends AbstractType {
    public function buildForm(FormBuilderInterface $builder, array $options): void {
        $builder
            ->add('name', null, [
                'label' => "form.trick.name.label", 
                'constraints' => [
                    new NotBlank([
                        'message' => "form.trick.name.not-blank", 
                    ]), 
                ], 
            ])
            ->add('description', null, [
                'label' => "form.trick.description.label", 
                'constraints' => [
                    new NotBlank([
                        'message' => "form.trick.description.not-blank", 
                    ]), 
                ], 
            ])
            ->add('category', EntityType::class, [
                'label' => "form.trick.category.label", 
                'constraints' => [
                    new NotBlank([
                        'message' => "form.trick.category.not-blank", 
                    ]), 
                ], 
                'class' => Category::class,
                'choice_label' => 'name',
            ])
            ->add('coverImage', MediaType::class, [
                'label' => false,
                'new' => true,
                'coverImage' => true,
            ])
            ->add('medias', CollectionType::class, [
                'entry_type' => MediaType::class,
                'label' => 'form.trick.medias.label',
                'allow_add' => true,
                'entry_options' => [
                    'new' => $options['new'],
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void {
        $resolver->setDefaults([
            'data_class' => Trick::class,
            'new' => false,
        ]);
    }
}
