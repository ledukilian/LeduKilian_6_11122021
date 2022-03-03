<?php

namespace App\Form;

use App\Entity\Comment;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\NotNull;

class CommentFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options = []): void
    {
        $builder
            ->add('content', TextareaType::class, [
                'required' => true,
                'label' => 'Commentaire',
                'attr' => ['class' => 'w-100'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez saisir un commentaire valide',
                    ]),
                    new NotNull([
                        'message' => 'Veuillez saisir un commentaire valide',
                    ]),
                    new Length([
                        'min' => 3,
                        'minMessage' => 'Votre commentaire doit contenir au moins {{ limit }} caractères',
                        'max' => 1024,
                        'maxMessage' => 'Votre commentaire ne doit pas contenir plus de {{ limit }} caractères',
                    ]),
                ],
            ])
            ->add('user', HiddenType::class, [
                'data' => '{{trick.id}}',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Comment::class,
        ]);
    }
}
