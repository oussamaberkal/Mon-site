<?php

namespace App\Form;

use App\Entity\AboNewsletter;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AboNewsletterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class, [
                'label'=> "Your email",
                'required'=> true,
                'invalid_message'=> "Veuillez renseigner un email valide",
            ])
            ->add('submit', SubmitType::class, [
                'label'=> "S'abonner a la newsletter",
            ])
            


        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => AboNewsletter::class,
        ]);
    }
}
