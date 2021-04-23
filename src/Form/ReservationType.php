<?php

namespace App\Form;

use App\Entity\Reservation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ReservationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('adresse', TextType::class, ['label' => "Adresse", ])
            ->add('telephone', NumberType::class, ['label' => "Telephone", ])
            ->add('nombre_personnes', NumberType::class, [
                'label' => "Nombre de personnes", 
                ])
            ->add('TypeVoyage', TextType::class, ['label' => "Type de voyage", ])
            ->add('submit', SubmitType::class, ['label' => "Envoyer",])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Reservation::class,
        ]);
    }
}
