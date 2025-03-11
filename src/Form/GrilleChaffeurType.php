<?php

namespace App\Form;

use App\Entity\Chauffeur;
use App\Entity\GrilleChauffeur;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GrilleChaffeurType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('jours', NumberType::class,[
                'label' => ' ',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'tarif de jour'
                ]
            ])
            ->add('nuit', NumberType::class,[
                'label' => ' ',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'tarif de nuit'
                ]
            ])
            ->add('location', NumberType::class,[
                'label' => ' ',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'pour location'
                ]
            ])
            ->add('circuit', NumberType::class,[
                'label' => ' ',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'tarif pour circuit'
                ]
            ])
            ->add('Chauffeur', EntityType::class, [
                'label' => ' ',
                'class' => Chauffeur::class,
                'choice_label' => 'idPersonne.prenom',
                'placeholder' => 'choisir le chauffeur...',
                'attr' => [
                    'class' => 'form-select'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => GrilleChauffeur::class,
        ]);
    }
}
