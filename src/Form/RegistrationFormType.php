<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\NotNull;

class RegistrationFormType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options = []): void
    {
        $builder
            ->add('username', TextType::class, [
                'required' => true,
                'label' => 'Nom d\'utilisateur',
                'attr' => ['class' => 'w-100'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez saisir un nom d\'utilisateur valide',
                    ]),
                    new NotNull([
                        'message' => 'Veuillez saisir un nom d\'utilisateur valide',
                    ]),
                    new Length([
                        'min' => 3,
                        'minMessage' => 'Votre nom d\'utilisateur doit contenir au moins {{ limit }} caractères',
                        'max' => 4096,
                        'maxMessage' => 'Votre nom d\'utilisateur ne doit pas contenir plus de {{ limit }} caractères',
                    ]),
                ],
            ])
            ->add('email', EmailType::class, [
                'required' => true,
                'label' => 'Adresse mail',
                'attr' => ['class' => 'w-100'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez saisir un email valide',
                    ]),
                    new NotNull([
                        'message' => 'Veuillez saisir un email valide',
                    ]),
                    new Email([
                        'message' => 'Veuillez saisir un format d\'email valide',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Votre email doit contenir au moins {{ limit }} caractères',
                        'max' => 4096,
                        'maxMessage' => 'Votre email ne doit pas contenir plus de {{ limit }} caractères',
                    ]),
                ],
            ])
            ->add('plainPassword', RepeatedType::class, [
                'required' => true,
                'type' => PasswordType::class,
                'invalid_message' => 'Les deux mots de passe doivent être identiques',
                'mapped' => false,
                'label' => 'Mot de passe',
                'first_options'  => ['label' => 'Mot de passe'],
                'second_options' => ['label' => 'Confirmation mot de passe'],
                'attr' => ['autocomplete' => 'new-password', 'class' => 'password-field w-100'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez entrer un mot de passe valide',
                    ]),
                    new NotNull([
                        'message' => 'Veuillez saisir un mot de passe valide',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Votre mot de passe doit contenir au moins {{ limit }} caractères',
                        'max' => 4096,
                        'maxMessage' => 'Votre mot de passe ne doit pas contenir plus de {{ limit }} caractères',
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
            'data_class' => User::class,
        ]);
    }
}
