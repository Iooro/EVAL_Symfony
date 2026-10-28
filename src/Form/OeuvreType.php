<?php

namespace App\Form;

use App\Entity\Artiste;
use App\Entity\Lieu;
use App\Entity\Oeuvre;
use App\Entity\Technique;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OeuvreType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre')
            ->add('date_creation')
            ->add('description')
            ->add('est_detruite')
            ->add('id_lieu', EntityType::class, [
                'class' => Lieu::class,
                'choice_label' => 'id',
            ])
            ->add('id_oeuvre_recouverte', EntityType::class, [
                'class' => Oeuvre::class,
                'choice_label' => 'id',
            ])
            ->add('id_artiste', EntityType::class, [
                'class' => Artiste::class,
                'choice_label' => 'id',
                'multiple' => true,
            ])
            ->add('id_technique', EntityType::class, [
                'class' => Technique::class,
                'choice_label' => 'id',
                'multiple' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Oeuvre::class,
        ]);
    }
}
