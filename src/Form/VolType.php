<?php

namespace App\Form;

use App\Entity\Vol;
use DateTime;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VolType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {  
        $vol = $options['data'];
        $builder
            ->add('date_de_depart',DateTimeType::class, [
                'label' => "Départ du vol ",
                'required' => false,
                'placeholder' => [
                    'year' => 'Année', 'month' => 'Mois', 'day' => 'Jour',
                    'hour' => 'Heure', 'minute' => 'Minute', 'second' => 'Seconde',
                ]
            ])
            ->add('date_debut_sejour',DateType::class, [
                'label' => "Date départ du vol confirmation ",
                'required' => false,
                'placeholder' => [
                    'year' => 'Année', 'month' => 'Mois', 'day' => 'Jour',
                ]
            ])
            ->add('date_fin_sejour',DateType::class, [
                'label' => "Date départ du vol confirmation",
                'required' => false,
                'placeholder' => [
                    'year' => 'Année', 'month' => 'Mois', 'day' => 'Jour',
                ]
            ])
            ->add('retour_date_de_depart',DateTimeType::class, [
                'label' => "Départ du vol ",
                'required' => false,
                'placeholder' => [
                    'year' => 'Année', 'month' => 'Mois', 'day' => 'Jour',
                    'hour' => 'Heure', 'minute' => 'Minute', 'second' => 'Seconde',
                ]
            ])
            ->add('date_arrive',DateTimeType::class, [
                'label' => "arrivé du vol",
                'required' => false,
                'placeholder' => [
                    'year' => 'Année', 'month' => 'Mois', 'day' => 'Jour',
                    'hour' => 'Heure', 'minute' => 'Minute', 'second' => 'Seconde',
                ]
            ])
            ->add('retour_date_arrive',DateTimeType::class, [
                'label' => "arrivé du vol",
                'required' => false,
                'placeholder' => [
                    'year' => 'Année', 'month' => 'Mois', 'day' => 'Jour',
                    'hour' => 'Heure', 'minute' => 'Minute', 'second' => 'Seconde',
                ]
            ])
            ->add('nom_aeroport_depart',TextType::class, [
                'label' => "Nom de l'aeroport de départ",
                'required' => false,
            ])
            ->add('pays',TextType::class, [
                'label' => "Nom du pays d'arrivé",
                'required' => false,
            ])
            ->add('nom_aeroport_arrive',TextType::class, [
                'label' => "Nom de l'aeroport d'arrivé",
                'required' => false,
            ])
            ->add('nom_ville_arrive',TextType::class, [
                'label' => "Nom de la ville de arrivé",
                'required' => false,
            ])
            ->add('duree_vol',TimeType::class, [
                'label' => "durée du vol",
                'required' => false,
                'placeholder' => [
                    'hour' => 'Heure', 'minute' => 'Minute', 'second' => 'Seconde',
                ]
            ])
            ->add('compagnie_depart',TextType::class, [
                'label' => "Nom de la compagnie du départ",
                'required' => false,
            ])
            ->add('compagnie_retour',TextType::class, [
                'label' => "Nom de la compagnie du retour",
                'required' => false,
            ])
            ->add('classe_affaire',NumberType::class, [
                'label' => "Nombre de place classe affaire",
                'required' => false,
            ])
            ->add('classe_economique',NumberType::class, [
                'label' => "Nombre de place classe économique",
                'required' => false,
            ])
            ->add('voyage_affaire', CheckboxType::class, [
                'label' => false,
                'required' => false,
            ])
            ->add('submit', SubmitType::class, [
                'label' =>$vol->getId() ? 'Modifier' : 'Ajouter'      
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Vol::class,
        ]);
    }
}
