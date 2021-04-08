<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ModifyPasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('currentPassword', PasswordType::class, [
                'label'=> "Ancien mot de passe",
            ])
            ->add('Password', RepeatedType::class, [
                'type' => PasswordType::class, 
                'invalid_message'=> "Les mots de passe doivent correspondre",
                'required'=> true,
                'first_options'=> ['label'=> 'Nouveau mot de passe'],
                'second_options'=>['label'=> 'Confirmer mot de passe'],  
            ])
            ->add('submit', SubmitType::class, [
                'label'=> "Modifier mot de passe",
            ])



        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
