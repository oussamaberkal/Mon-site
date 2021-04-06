<?php

namespace App\Form;

use App\Entity\ContactPro;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactProType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('pseudo',TextType::class,[
                'label' => "Pseudo",
                'required' => false,])
            ->add('email',TextType::class,[
                'label' => "Email",
                'required' => false,])
            ->add('subject',TextType::class,[
                'label' => "Sujet",
                'required' => false,])
            ->add('message',TextareaType::class,[
                'label' => "Message",
                'required' => false,])
            ->add('submit', SubmitType::class,['label'=> "Envoyer"])    
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ContactPro::class,
        ]);
    }
}
