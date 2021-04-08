<?php

namespace App\Form;

use App\Entity\Newsletter;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class NewsletterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $newsletter = $options['data'];

        $builder
            ->add('objet', TextType::class, [
                'label' => "Objet de l'email",
            ])
            ->add('text', TextareaType::class, [
                'label' => 'Texte',
            ])
            ->add('submit', SubmitType::class, [
                'label' => $newsletter->getId() ? 'Modifier Newsletter' : 'Enregistrer Newsletter'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Newsletter::class,
        ]);
    }
}
