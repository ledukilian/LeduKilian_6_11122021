<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Trick;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\NotNull;

class TrickType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'required' => true,
                'label' => 'Nom',
                'attr' => ['class' => 'w-100'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez saisir un nom de trick valide',
                    ]),
                    new NotNull([
                        'message' => 'Veuillez saisir un nom de trick valide',
                    ]),
                    new Length([
                        'min' => 3,
                        'minMessage' => 'Votre nom de trick doit contenir au moins {{ limit }} caractères',
                        'max' => 1024,
                        'maxMessage' => 'Votre nom de trick ne doit pas contenir plus de {{ limit }} caractères',
                    ]),
                ],
            ])
            ->add('description', TextareaType::class, [
                'required' => true,
                'label' => 'Description',
                'attr' => ['class' => 'w-100'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez saisir une description valide',
                    ]),
                    new NotNull([
                        'message' => 'Veuillez saisir une description valide',
                    ]),
                ],
            ])
            ->add('category', EntityType::class, [
                'class' => Category::class,
                'choice_label' => 'name',
                'required' => true,
                'label' => 'Catégorie',
                'attr' => ['class' => 'w-100'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez saisir une catégorie valide',
                    ]),
                    new NotNull([
                        'message' => 'Veuillez saisir une catégorie valide',
                    ]),
                ],
            ])
            ->add('save', SubmitType::class, [
                'label' => 'Ajouter'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Trick::class,
        ]);
    }
}
