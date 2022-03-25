<?php

namespace App\Form;


use App\Entity\Media;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Image;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\Constraints\Url;

class TrickMediaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('type', ChoiceType::class, [
                'mapped' => false,
                'required' => true,
                'multiple' => false,
                'expanded' => true,
                'label' => 'Type de média',
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
            ->add('image', FileType::class, [
                'mapped' => false,
                'required' => true,
                'label' => 'Fichier',
                'label_attr' => ['class' => 'd-none'],
                'attr' => ['class' => 'w-100 d-none'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez ajouter une image',
                    ]),
                    new Image([
                        'allowPortrait' => false,
                        'allowPortraitMessage' => 'Vous ne pouvez pas ajouter une image en portrait',
                    ]),
                    new NotNull([
                        'message' => 'Veuillez ajouter une image',
                    ]),
                ],
            ])
            ->add('alt', TextType::class, [
                'required' => true,
                'label' => 'Texte alternatif',
                'label_attr' => ['class' => 'd-none'],
                'attr' => ['class' => 'w-100 d-none'],
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
                        'maxMessage' => 'Votre texte alternatif ne doit pas contenir plus de {{ limit }} caractères',
                    ]),
                ],
            ])
            ->add('url', UrlType::class, [
                'mapped' => false,
                'required' => true,
                'label' => 'Lien',
                'label_attr' => ['class' => 'd-none'],
                'attr' => ['class' => 'w-100 d-none'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez saisir une URL valide',
                    ]),
                    new NotNull([
                        'message' => 'Veuillez saisir une URL valide',
                    ]),
                    new Url([
                        'message' => 'Veuillez saisir une URL valide',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Votre URL doit contenir au moins {{ limit }} caractères',
                        'max' => 1024,
                        'maxMessage' => 'Votre URL ne doit pas contenir plus de {{ limit }} caractères',
                    ]),
                ],
            ])
        ;
    }
}
