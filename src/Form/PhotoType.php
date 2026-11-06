<?php

namespace App\Form;

use App\Entity\Oeuvre;
use App\Entity\Photo;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class PhotoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('date_prise_vue')
            ->add('nom_fichier', FileType::class, [
                'label' => 'Image',
                'mapped' => false,
                'required' => $options['data']->getId() === null,
                'help' => 'JPEG, PNG ou WebP. En modification, laissez vide pour conserver l’image.',
            ])
            ->add('etat_oeuvre')
            ->add('id_oeuvre', EntityType::class, [
                'class' => Oeuvre::class,
                'choice_label' => 'titre',
                'placeholder' => 'Sélectionner une Oeuvre',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Photo::class,
        ]);
    }
}
