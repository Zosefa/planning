<?php

namespace App\Form;

use App\Entity\Chauffeur;
use App\Entity\Marque;
use App\Entity\Voiture;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VoitureType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('voiture',TextType::class,[
                'label' => ' ',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'voiture'
                ]
            ])
            ->add('matricule',TextType::class,[
                'label' => ' ',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'matricule'
                ]
            ])
            ->add('place',NumberType::class,[
                'label' => ' ',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'place'
                ]
            ])
            ->add('idMarque', EntityType::class, [
                'label' => ' ',
                'class' => Marque::class,
                'choice_label' => 'marque',
                'attr' => [
                    'class' => 'form-select'
                ],
                'placeholder' => 'Choisir la marque du voiture...',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Voiture::class,
        ]);
    }
}
