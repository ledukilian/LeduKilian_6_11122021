<?php

namespace App\Form;


use App\Entity\Media;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Test\FormInterface;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\Image;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TrickMediaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('type', ChoiceType::class, [
                'mapped' => true,
                'required' => true,
                'multiple' => false,
                'expanded' => true,
                'label' => 'Type de média :',
                'choices' => [
                    'Image' => Media::MEDIA_TYPE_IMAGE,
                    'Vidéo' => Media::MEDIA_TYPE_VIDEO
                ],
                'attr' => ['class' => 'w-100'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez saisir un texte alternatif valide',
                    ]),
                ],
            ])
            ->add('embed', TextareaType::class, [
                'mapped' => false,
                'required' => false,
                'label' => 'Embed de la vidéo',
                'label_attr' => ['class' => 'field-video'],
                'attr' => ['class' => 'w-100 field-video'],
                'validation_groups' => ['video'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez saisir une URL valide',
                    ]),
                    new NotNull([
                        'message' => 'Veuillez saisir une URL valide',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Votre embed doit contenir au moins {{ limit }} caractères',
                        'max' => 1024,
                        'maxMessage' => 'Votre embed ne doit pas contenir plus de {{ limit }} caractères',
                    ]),
                ],
            ])
            ->add('image', FileType::class, [
                'mapped' => false,
                'required' => false,
                'label' => 'Fichier',
                'label_attr' => ['class' => 'field-image'],
                'attr' => ['class' => 'w-100 field-image'],
                'validation_groups' => ['image'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez ajouter une image',
                    ]),
                    new Image([
                        'allowPortrait' => false,
                        'allowPortraitMessage' => 'Vous ne pouvez pas ajouter une image en portrait',
                    ]),
                    new File([
                        'maxSize' => '1024k',
                        'maxSizeMessage' => 'Votre image ne doit pas dépasser {{ limit }} Ko',
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/png',
                            'image/gif',
                        ],
                        'mimeTypesMessage' => 'Votre image doit être au format jpeg, png ou gif',
                    ]),
                    new NotNull([
                        'message' => 'Veuillez ajouter une image',
                    ]),
                ],
            ])
            ->add('alt', TextType::class, [
                'required' => false,
                'label' => 'Texte alternatif',
                'label_attr' => ['class' => 'field-image'],
                'attr' => ['class' => 'w-100 field-image'],
                'validation_groups' => ['image'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez saisir un texte alternatif valide',
                    ]),
                    new NotNull([
                        'message' => 'Veuillez saisir un texte alternatif valide',
                    ]),
                    new Length([
                        'min' => 3,
                        'minMessage' => 'Votre texte alternatif doit contenir au moins {{ limit }} caractères',
                        'max' => 1024,
                        'groups' => ['image'],
                        'maxMessage' => 'Votre texte alternatif ne doit pas contenir plus de {{ limit }} caractères',
                    ]),
                ],
            ])
        ;
    }


    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Media::class,
            'new' => false,
            'coverImage' => false,
            'validation_groups' => function (Form $form) {

                $media = $form->getData();
                $config = $form->getConfig();

                if (is_null($media->getId())) {
                    $groups = ['image', 'video'];

                    if (!$config->getOption("coverImage")) {
                        switch ($form->get("type")->getData()) {
                            case Media::MEDIA_TYPE_IMAGE:
                                $groups = ['image'];
                                break;
                            case Media::MEDIA_TYPE_VIDEO:
                                $groups = ['video'];
                                break;
                            default:
                                $groups = [];
                                break;
                        }
                    }
                } else {
                    $groups = ['video'];
                }

                $groups[] = "Default";

                dump($groups);
                return array_unique($groups);
            }
        ]);

    }

}
