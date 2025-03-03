<?php

namespace App\Form;

use App\Entity\Client;
use App\Entity\Nationalite;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AgenceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Agence',TextType::class,[
                'label' => ' ',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'nom de l\'agence'
                ]
            ])
            ->add('IdNationalite', EntityType::class, [
                'label' => ' ',
                'class' => Nationalite::class,
                'choice_label' => 'nationalite',
                'attr' => [
                    'class' => 'form-select'
                ],
                'placeholder' => 'choisir une provenance...'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Client::class,
        ]);
    }
}
