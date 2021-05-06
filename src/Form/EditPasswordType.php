<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Security\Core\Validator\Constraints\UserPassword;

class EditPasswordType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('old_password', PasswordType::class, [
                'label' => 'Entrez votre mot de passe actuel',
                'constraints' => [
                    new NotBlank(),
                    new UserPassword(),
                ]
            ])
            ->add('new_password', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => "Votre mot de passe doit être similaire à la confirmation.",
                'first_options' => [
                    'label' => "Entrez un mot de passe"
                ],
                'second_options' => [
                    'label' => "Confirmez votre mot de passe"
                ],
                'constraints' => [
                    new Length(['min' => 8]),
                    new NotBlank()
                ]
            ])
        ;
    }
}