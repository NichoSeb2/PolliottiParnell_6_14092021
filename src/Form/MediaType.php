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

                $fileAttr = [];
                $fileAltAttr = [];

                if (!$options['coverImage']) {
                    $form
                        ->add('type', ChoiceType::class, [
                            'priority' => 3,
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
                        ->add('url', UrlType::class, [
                            'priority' => 1,
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

                    $messageKey = "medias.file";
                    $constraintsGroups = ['image'];
                    $fileAttr = [
                        'file' => true,
                        'dynamicRequire' => true,
                    ];
                    $fileAltAttr = $fileAttr;
                } else {
                    $messageKey = "cover-image";
                    $constraintsGroups = ['Default'];
                }

                $form
                    ->add('file', FileType::class, [
                        'label' => "form.trick.$messageKey.label",
                        'priority' => 2,
                        'attr' => array_unique(array_merge($fileAttr, [
                            'accept' => Media::ACCEPT_MIME_TYPE,
                        ])),
                        'required' => (!$options['coverImage'] ? false : $options['new']),
                        'mapped' => false,
                        'constraints' => [
                            new File([
                                'mimeTypes' => [
                                    Media::ACCEPT_MIME_TYPE,
                                ],
                                'mimeTypesMessage' => "form.trick.$messageKey.wrong-mime-type",
                                'groups' => $constraintsGroups,
                            ]),
                            new NotBlank([
                                'message' => "form.trick.$messageKey.not-blank",
                                'groups' => $constraintsGroups,
                            ])
                        ]
                    ])
                    ->add('alt', null, [
                        'label' => "form.trick.$messageKey.alt.label",
                        'priority' => 2,
                        'attr' => $fileAltAttr,
                        'required' => true,
                        'mapped' => true,
                        'constraints' => [
                            new NotBlank([
                                'message' => "form.trick.$messageKey.alt.not-blank",
                                'groups' => $constraintsGroups,
                            ]),
                        ],
                    ])
                ;
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
