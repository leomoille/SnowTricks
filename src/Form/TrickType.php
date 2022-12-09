<?php

namespace App\Form;

use App\Entity\Trick;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class TrickType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Titre de la figure',
                'required' => true,
            ])
            ->add('trickCategory', EntityType::class, [
                'label' => 'Groupe',
                'class' => 'App\Entity\TrickCategory',
                'choice_label' => 'name',
                'multiple' => false,
                'expanded' => false,
            ])
            ->add('content', TextareaType::class, [
                'label' => 'Description de la figure',
                'help' => 'Décrivez comment réaliser cette figure, si elle est plutôt rapide à maitriser ou si elle est réservée aux plus grand maitres de la glisse !',
            ])
            ->add('image', CollectionType::class, [
                'label' => 'Photo(s) de la figure',
                'help' => 'Utilisez uniquement des images aux formats .jpg, .jpeg ou .png.',
                'entry_type' => ImageType::class,
                'entry_options' => ['label' => false],
                'prototype' => true,
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
                'block_name' => 'images_list',
            ])
            ->add('video', CollectionType::class, [
                'label' => 'Vidéo(s) de la figure',
                'help' => 'Utilisez uniquement le lien obtenu en cliquant sur le bouton de partage d\'une vidéo YouTube.',
                'entry_type' => VideoType::class,
                'entry_options' => ['label' => false],
                'prototype' => true,
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Trick::class,
        ]);
    }
}
