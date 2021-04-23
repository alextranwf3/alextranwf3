<?php

namespace App\Form;


use App\Entity\Vol;
use App\Entity\SearchData;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchFormType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('q', TextType::class, [
                'label' => false,
                'required' => false,
                'attr' => [
                    'placeholder' => 'Rechercher ville'
                ]
            ])
            ->add('lieuDepart', HiddenType::class, [
                'label' => false,
                'required' => false,
                'attr' => [
                    'placeholder' => 'Rechercher l\'aéroport de départ'
                ]
            ])
            // ->add('vols', EntityType::class, [
            //     'label' => false,
            //     'required' => false,
            //     'class' => Vol::class,
            //     'expanded' => true,
            //     'multiple' => true,
                        
            // ])
            ->add('min', NumberType::class, [
                'label' => false,
                'required' => false,
                'attr' => [
                    'placeholder' => 'Prix min'
                ]
            ])
            ->add('max', NumberType::class, [
                'label' => false,
                'required' => false,
                'attr' => [
                    'placeholder' => 'Prix max'
                ]
            ])
            ->add('affaire', CheckboxType::class, [
                'label' => 'Classe affaire',
                'required' => false,
            ])
            ->add('economie', CheckboxType::class, [
                'label' => 'Classe économie',
                'required' => false,
            ])
            ->add('promotion', CheckboxType::class, [
                'label' => 'Promotion',
                'required' => false,
            ])

            ->add('pays', ChoiceType::class, [
                'label' => 'choisir une destination',
                'required' => false,
                'choices' => [
                    'France' => 'france',
                    'Espagne' => 'espagne',
                    'île Maurice' => 'ile maurice',
                    'Egypte' => 'egypte',
                    'Croatie' => 'croatie',
                  ],
                
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'rechercher'     
            ])
            ->add('depart',DateType::class, [
                'label' => "Date de depart du voyage",
                'required' => false,
                'widget' => 'single_text',
                // this is actually the default format for single_text
                'format' => 'yyyy-MM-dd',
                'attr' => ['class' => 'js-datepicker'],
                'placeholder' => [
                    'year' => 'Année', 'month' => 'Mois', 'day' => 'Jour',
                ]
            ])
            ->add('retour',DateType::class, [
                'label' => "Date de retour du voyage",
                'required' => false,
                'widget' => 'single_text',
                'placeholder' => [
                    'year' => 'Année', 'month' => 'Mois', 'day' => 'Jour',
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => SearchData::class,
            'method' => 'GET',
            'csrf_protection' => false
        ]);
    }

    public function getBlockPrefix()
    {
        return '';
    }

}