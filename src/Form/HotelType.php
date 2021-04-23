<?php

namespace App\Form;

use App\Entity\Hotel;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class HotelType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $hotel = $options['data'];
        $builder
            ->add('nom',TextType::class, [
                'label' => "Nom de l'hôtel",
                'required' => false,
            ])
            ->add('adresse',TextType::class, [
                'label' => "Adresse de l'hôtel",
                'required' => false,
            ])
            ->add('image', FileType::class, [
                'label' => 'Ajoutez une image de l\'hotel',
                'mapped' => false,      
            ])
            ->add('image2', FileType::class, [
                'label' => 'Ajoutez une deuxieme image de l\'hotel',
                'mapped' => false,      
            ])
            ->add('image3', FileType::class, [
                'label' => 'Ajoutez une troisieme image de l\'hotel',
                'mapped' => false,      
            ])
            ->add('image4', FileType::class, [
                'label' => 'Ajoutez une quatrième image de l\'hotel',
                'mapped' => false,      
            ])
            ->add('prix', NumberType::class, [
                'label' => "Insérer le prix du séjour",
                'required' => false,
            ])
            ->add('etoile', NumberType::class, [
                'label' => "Nombre d'étoiles",
                'required' => false,
            ])
            ->add('promotion_prix', NumberType::class, [
                'label' => "Si Promotion insérer le prix avant la promotion du séjour",
                'required' => false,
            ])
            ->add('description', TextareaType::class, [
                'label' => "description de l'hotel",
                'required' => false,
            ])
            ->add('promotion', CheckboxType::class, [
                'label' => false,
                'required' => false,
            ])
            ->add('submit', SubmitType::class, [
                'label' =>$hotel->getId() ? 'Modifier' : 'Ajouter'      
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Hotel::class,
        ]);
    }
}
