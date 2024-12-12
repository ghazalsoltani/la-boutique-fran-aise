<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;

class RegisterUserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'label' => "votre adresse email",
                'attr' => [
                    'placeholder' => "Indiquez votre adresse Email"
                ]
            ])
            ->add('plainPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'constraints'=> [
                    new length([
                        'min'=>4,
                        'max'=>30
                        ]
                    )],
                'first_options' => [
                    'label' => 'votre mot de passe',
                    'attr' => [
                        'placeholder' => "Choisissez votre mot de passe"
                    ],
                    'hash_property_path' => 'password'
                ],

                'second_options' => [
                    'label' => 'Confirmez votre mot de passe',
                    'attr' => [
                        'placeholder' => "Confirmez votre mot de passe"
                    ]
                ],
                'mapped' => false,
            ])
            ->add('firstname', TextType::class, [
                'label' => "votre prénom",
                'attr' => [
                    'placeholder' => "Indiquez votre prénom"
                ]
            ])
            ->add('lastname', TextType::class, [
                'label' => "votre nom",
                'attr' => [
                    'placeholder' => "Indiquez votre nom"
                ]
            ])
            ->add('submit', SubmitType::class, [
                'label' => "valider",
                'attr' => [
                    'class' => "btn btn-success"
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'constraints'=>[
                new UniqueEntity([
                    // The entity class to check uniqueness against
                    'entityClass'=>User::class,
                    // The specific field to check for uniqueness
                    'fields'=>'email'
                ])
            ],
            // The form is mapped to the User entity
            'data_class' => User::class,
        ]);
    }
}
//Password constraints are added directly to the field because it's field-specific and not mapped.
//Email's uniqueness is an entity-level constraint that applies to the database, so it's added in configureOptions.