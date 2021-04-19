<?php

namespace App\Form;

use App\Entity\Member;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MemberType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('lastname', TextType::class, [
                'label' => 'Nom'
            ])
            ->add('firstname', TextType::class, [
                'label' => 'Prénom'
            ])
            ->add('email', EmailType::class, [
                'label' => 'Email'
            ])
            ->add('currentJob', TextType::class, [
                'label'     => 'Travail/Etude Actuel',
                'required'  => false
            ])
            ->add('facebookLink', UrlType::class, [
                'label'     => 'URL Facebook',
                'required'  => false
            ])
            ->add('linkedinLink', UrlType::class, [
                'label'     => 'URL Linkedin',
                'required'  => false
            ])
            ->add('picture')
            ->add('isHidden', CheckboxType::class, [
                'label'     => 'Voulez-vous cacher ce profil ?',
                'required'  => false
            ])
            ->add('promotion')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Member::class,
        ]);
    }
}
