<?php

namespace App\Form;

use App\Entity\Categorie;
use App\Entity\Jeux;
use App\Entity\Plateforme;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class JeuxType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $jeux = $options['data'];

        $builder
            ->add('nom', TextType::class, [
                'label' => 'Nom du jeu',
            ])
            ->add('categorie', EntityType::class, [
                'class' => Categorie::class,
                'multiple' => true,
                'choice_label' => 'categorie',
            ])
            ->add('plateforme', EntityType::class, [
                'class' => Plateforme::class,
                'multiple' => true,
                'choice_label' => 'nom',
            ])
            ->add('dateSortie', DateType::class, [
                'label' => 'Date sortie du jeu',
                'widget' => 'single_text',
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description',
            ])
            ->add('lienYoutube', TextType::class, [
                'label' => 'Lien vidéo Youtube',
            ])
            ->add('editeur', TextType::class, [
                'label' => 'Editeur du jeu',
            ])
            ->add('dev', TextType::class, [
                'label' => 'Studio de developpement du jeu',
            ])
            ->add('image', FileType::class, [
                'label' => 'Ajouter une image',
                'mapped' => false,
                'required' => false,
            ])
            ->add('submit', SubmitType::class, [
                'label' => $jeux->getId() ? 'Modifier Jeu' : 'Ajouter Jeu'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Jeux::class,
        ]);
    }
}
