<?php

namespace App\Form;

use App\Entity\Media;
use App\Service\VideoIdExtractor;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Url;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\Regex;
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

                if (!$options['coverImage']) {
                    $form
                        ->add('type', ChoiceType::class, [
                            'label' => 'form.trick.medias.type.label',
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
                                    'message' => 'form.trick.medias.type.not-blank',
                                ])
                            ]
                        ])
                    ;
                }

                if ($options['coverImage']) {
                    $fileOptions = [
                        'label' => "form.trick.cover-image.label",
                        'attr' => [
                            'accept' => Media::ACCEPT_MIME_TYPE,
                        ],
                        'required' => $options['new'],
                        'mapped' => false,
                        'constraints' => [
                            'file' => [
                                'message' => "form.trick.cover-image.wrong-mime-type",
                                'groups' => ['Default']
                            ],
                            'not-blank' => [
                                'message' => "form.trick.cover-image.not-blank",
                                'groups' => ['Default']
                            ],
                        ],
                        'alt' => [
                            'label' => "form.trick.cover-image.alt.label",
                            'attr' => [],
                            'required' => true,
                            'mapped' => false,
                            'constraints' => [
                                'not-blank' => [
                                    'message' => "form.trick.cover-image.alt.not-blank",
                                    'groups' => ['Default']
                                ],
                            ],
                        ],
                    ];
                } else {
                    $fileOptions = [
                        'label' => "form.trick.medias.file.label",
                        'attr' => [
                            'accept' => Media::ACCEPT_MIME_TYPE,
                                'file' => true,
                                'dynamicRequire' => true,
                        ],
                        'required' => false,
                        'mapped' => false,
                        'constraints' => [
                            'file' => [
                                'message' => "form.trick.medias.file.wrong-mime-type",
                                'groups' => ['image']
                            ],
                            'not-blank' => [
                                'message' => "form.trick.medias.file.not-blank",
                                'groups' => ['image']
                            ],
                        ],
                        'alt' => [
                            'label' => "form.trick.medias.file.alt.label",
                            'attr' => [
                                'file' => true,
                                'dynamicRequire' => true,
                            ],
                            'required' => false,
                            'mapped' => false,
                            'constraints' => [
                                'not-blank' => [
                                    'message' => "form.trick.medias.file.alt.not-blank",
                                    'groups' => ['image']
                                ],
                            ],
                        ],
                    ];
                }

                $form
                    ->add('file', FileType::class, [
                        'label' => $fileOptions['label'],
                        'attr' => $fileOptions['attr'],
                        'required' => $fileOptions['required'],
                        'mapped' => $fileOptions['mapped'],
                        'constraints' => [
                            new File([
                                'mimeTypes' => [
                                    Media::ACCEPT_MIME_TYPE,
                                ],
                                'mimeTypesMessage' => $fileOptions['constraints']['file']['message'],
                                'groups' => $fileOptions['constraints']['file']['groups'],
                            ]),
                            new NotBlank([
                                'message' => $fileOptions['constraints']['not-blank']['message'],
                                'groups' => $fileOptions['constraints']['not-blank']['groups'],
                            ])
                        ]
                    ])
                    ->add('alt', null, [
                        'label' => $fileOptions['alt']['label'],
                        'attr' => $fileOptions['alt']['attr'],
                        'required' => $fileOptions['alt']['required'],
                        'mapped' => $fileOptions['alt']['mapped'],
                        'constraints' => [
                            new NotBlank([
                                'message' => $fileOptions['alt']['constraints']['not-blank']['message'],
                                'groups' => $fileOptions['alt']['constraints']['not-blank']['groups'],
                            ]),
                        ],
                    ])
                ;

                if (!$options['coverImage']) {
                    $form
                        ->add('url', UrlType::class, [
                            'label' => 'form.trick.medias.url.label',
                            'attr' => [
                                'url' => true,
                                'dynamicRequire' => true,
                            ],
                            'trim' => true,
                            'required' => false,
                            'mapped' => false,
                            'constraints' => [
                                new Url([
                                    'message' => 'form.trick.medias.url.not-url',
                                    'groups' => ['video'],
                                ]),
                                new Regex([
                                    'value' => VideoIdExtractor::VIDEO_URL_REGEX,
                                    'message' => "form.trick.medias.url.wrong-url-format",
                                    'groups' => ['video'],
                                ]),
                                new NotBlank([
                                    'message' => "form.trick.medias.url.not-blank",
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
                    switch ($form->get('type')->getData()) {
                        case Media::MEDIA_TYPE_LOCAL_FILE:
                            $groups = ['image'];
                            break;
                        case Media::MEDIA_TYPE_URL:
                            $groups = ['video'];
                            break;
                        default:
                            $groups = [];
                            break;
                    }
                }

                $groups[] = "Default";

                return array_unique($groups);
            }
        ]);
    }
}
