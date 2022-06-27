<?php

namespace App\Form;


use App\Entity\Media;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\Image;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MediaType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
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
                    'Image' => Media::TYPE_IMAGE,
                    'Vidéo' => Media::TYPE_VIDEO
                ],
                'attr' => ['class' => 'w-100'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez saisir un type valide',
                    ]),
                ],
            ])
            ->add('link', TextareaType::class, [
                'mapped' => true,
                'required' => false,
                'label' => 'Embed de la vidéo',
                'label_attr' => ['class' => 'field-video'],
                'attr' => ['class' => 'w-100 field-video'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez saisir un embed valide',
                        'groups' => [Media::TYPE_VIDEO]
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Votre embed doit contenir au moins {{ limit }} caractères',
                        'max' => 1024,
                        'maxMessage' => 'Votre embed ne doit pas contenir plus de {{ limit }} caractères',
                        'groups' => [Media::TYPE_VIDEO]
                    ]),
                ],
            ])
            ->add('image', FileType::class, [
                'mapped' => false,
                'required' => false,
                'label' => 'Fichier',
                'label_attr' => ['class' => 'field-image'],
                'attr' => ['class' => 'w-100 field-image'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez ajouter une image',
                        'groups' => [Media::TYPE_IMAGE]
                    ]),
                    new File([
                        'maxSize' => '8M',
                        'maxSizeMessage' => 'Votre image est trop grosse : ({{ size }} {{ suffix }}). La taille limite autorisée est de {{ limit }} {{ suffix }}',
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/png',
                            'image/gif',
                        ],
                        'mimeTypesMessage' => 'Votre image doit être au format jpeg, png ou gif',
                        'groups' => [Media::TYPE_IMAGE]
                    ]),
                    new Image([
                        'allowPortrait' => false,
                        'allowPortraitMessage' => 'Vous ne pouvez pas ajouter une image en portrait',
                        'groups' => [Media::TYPE_IMAGE]

                    ]),
                ],
            ])
            ->add('alt', TextType::class, [
                'required' => false,
                'label' => 'Texte alternatif',
                'label_attr' => ['class' => 'field-image'],
                'attr' => ['class' => 'w-100 field-image'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez saisir un texte alternatif valide',
                        'groups' => [Media::TYPE_IMAGE]
                    ]),
                    new Length([
                        'min' => 3,
                        'minMessage' => 'Votre texte alternatif doit contenir au moins {{ limit }} caractères',
                        'max' => 1024,
                        'maxMessage' => 'Votre texte alternatif ne doit pas contenir plus de {{ limit }} caractères',
                        'groups' => [Media::TYPE_IMAGE]
                    ]),
                ],
            ])
        ;
    }


    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Media::class,
            'new' => false,
            'coverImage' => false,
            'validation_groups' => function (Form $form) {
                $media = $form->getData();
                if (is_null($media->getId())) {
                    return array($media->getType());
                }
                return ['Default'];
            }
        ]);
    }

}
