<?php

namespace App\Form;

use App\Entity\Media;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Url;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class MediaType extends AbstractType {
    public function buildForm(FormBuilderInterface $builder, array $options): void {
        $builder
            ->addEventListener(FormEvents::POST_SET_DATA, function (FormEvent $event) {
                /** @var Media $media */
                $media = $event->getData();
                $form = $event->getForm();
                $config = $form->getConfig();
                $options = $config->getOptions();

                if ($options['coverImage']) {
                    $form
                        ->add('file', FileType::class, [
                            'label' => "form.trick.cover-image.label",
                            'attr' => [
                                'accept' => Media::ACCEPT_MIME_TYPE
                            ],
                            'required' => $options['new'],
                            'mapped' => false,
                            'constraints' => [
                                new File([
                                    'mimeTypes' => [
                                        Media::ACCEPT_MIME_TYPE,
                                    ],
                                    'mimeTypesMessage' => "form.trick.cover-image.wrong-mime-type",
                                ]),
                                new NotBlank([
                                    'message' => "form.trick.cover-image.not-blank",
                                ])
                            ]
                        ])
                        // ->add('alt', null, [
                        //     'label' => "form.trick.cover-image.alt.label",
                        //     'required' => false,
                        //     'constraints' => [
                        //         new NotBlank([
                        //             'message' => "form.trick.cover-image.alt.not-blank",
                        //         ]),
                        //     ],
                        // ])
                    ;
                } else {
                    $form
                        ->add('type', ChoiceType::class, [
                            'label' => 'form.trick.media.type.label',
                            'attr' => [
                                'data-controller' => "media-type-switch media-label-fix",
                                'class' => "d-flex justify-content-center"
                            ],
                            'choices' => [
                                'Image' => Media::MEDIA_TYPE_LOCAL_FILE,
                                'Vidéo' => Media::MEDIA_TYPE_URL
                            ],
                            'expanded' => true,
                            'multiple' => false,
                            'required' => true,
                            'mapped' => false,
                            'constraints' => [
                                new NotBlank([
                                    'message' => 'form.trick.media.type.not-blank',
                                ])
                            ]
                        ])
                        ->add('file', FileType::class, [
                            'label' => "form.trick.media.file.label",
                            'attr' => [
                                'accept' => Media::ACCEPT_MIME_TYPE,
                                'file' => true,
                                'dynamicRequire' => true,
                            ],
                            'required' => false,
                            'mapped' => false,
                            'constraints' => [
                                new File([
                                    'mimeTypes' => [
                                        Media::ACCEPT_MIME_TYPE,
                                    ],
                                    'mimeTypesMessage' => "form.trick.media.file.wrong-mime-type",
                                    'groups' => ['image'],
                                ]),
                                new NotBlank([
                                    'message' => "form.trick.media.file.not-blank",
                                    'groups' => ['image'],
                                ])
                            ]
                        ])
                        ->add('alt', null, [
                            'label' => "form.trick.media.file.alt.label",
                            'attr' => [
                                'file' => true,
                                'dynamicRequire' => true,
                            ],
                            'required' => false,
                            'mapped' => false,
                            'constraints' => [
                                new NotBlank([
                                    'message' => "form.trick.media.file.alt.not-blank",
                                    'groups' => ['image'],
                                ]),
                            ],
                        ])
                        ->add('url', UrlType::class, [
                            'label' => 'form.trick.media.url.label',
                            'attr' => [
                                'url' => true,
                                'dynamicRequire' => true,
                            ],
                            'trim' => true,
                            'required' => false,
                            'mapped' => false,
                            'constraints' => [
                                new Url([
                                    'message' => 'form.trick.media.url.not-url',
                                    'groups' => ['video'],
                                ]),
                                new NotBlank([
                                    'message' => "form.trick.media.url.not-blank",
                                    'groups' => ['video'],
                                ])
                            ]
                        ])
                    ;
                }
            })
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void {
        $resolver->setDefaults([
            'data_class' => Media::class,
            'new' => false,
            'coverImage' => false,
            'validation_groups' => function (FormInterface $form) {
                $groups = ['image', 'video'];

                if (!$form->getConfig()->getOption('coverImage')) {
                    if ($form->get('type')->getData() == Media::MEDIA_TYPE_LOCAL_FILE) {
                        $groups = ['image'];
                    }

                    if ($form->get('type')->getData() == Media::MEDIA_TYPE_URL) {
                        $groups = ['video'];
                    }
                }

                $groups[] = "Default";

                return array_unique($groups);
            }
        ]);
    }
}
