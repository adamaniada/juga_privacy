<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class RegistrationFormType extends AbstractType
{

    // src/Form/RegistrationFormType.php

public function buildForm(FormBuilderInterface $builder, array $options): void
{
    $builder
        ->add('name', TextType::class, [
            'label' => 'Nom complet',
            'constraints' => [
                new NotBlank([
                    'message' => 'Le nom est obligatoire. Veuillez entrer votre nom complet.',
                ]),
                new Length([
                    'max' => 255,
                    'maxMessage' => 'Le nom ne doit pas dépasser {{ limit }} caractères.',
                ]),
            ],
        ])
        ->add('email', EmailType::class, [
            'label' => 'Adresse Email',
            'constraints' => [
                new NotBlank([
                    'message' => 'L\'adresse email est obligatoire. Veuillez entrer une adresse email valide.',
                ]),
                new Email([
                    'message' => 'Veuillez entrer une adresse email valide.',
                ]),
                new Length([
                    'max' => 255,
                    'maxMessage' => 'L\'adresse email ne doit pas dépasser {{ limit }} caractères.',
                ]),
            ],
        ])
        ->add('plainPassword', PasswordType::class, [
            'mapped' => false,
            'attr' => ['autocomplete' => 'new-password'],
            'constraints' => [
                new NotBlank([
                    'message' => 'Le mot de passe est obligatoire. Veuillez entrer un mot de passe.',
                ]),
                new Length([
                    'min' => 6,
                    'minMessage' => 'Le mot de passe doit contenir au moins {{ limit }} caractères.',
                    'max' => 4096,
                    'maxMessage' => 'Le mot de passe ne doit pas dépasser {{ limit }} caractères.',
                ]),
            ],
        ])
        ->add('companyName', TextType::class, [
            'label' => 'Nom de l\'entreprise',
            'mapped' => false,
            'constraints' => [
                new NotBlank([
                    'message' => 'Le nom de l\'entreprise est obligatoire. Veuillez entrer le nom de votre entreprise.',
                ]),
            ],
        ])
        ->add('companyAddress', TextType::class, [
            'label' => 'Adresse de l\'entreprise',
            'mapped' => false,
        ])
        ->add('companyContact', TextType::class, [
            'label' => 'Contact de l\'entreprise',
            'mapped' => false,
        ])
        ->add('companySector', TextType::class, [
            'label' => 'Secteur de l\'entreprise',
            'mapped' => false,
        ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
