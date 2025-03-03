<?php

namespace App\Form;

use App\Entity\Voiture;
use App\Entity\VoitureDisponible;
use App\Entity\VoitureNonDisponible;
use App\Repository\VoitureRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PanneType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('dateNonDisponible', null, [
                'label' => 'Date de panne de la voiture',
                'widget' => 'single_text',
                'attr' => [
                    'class' => 'form-control'
                ] 
            ])
            ->add('Motif',TextareaType::class,[
                'label' => ' ',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'cause du panne'
                ]
            ])
            ->add('idVoiture', EntityType::class, [
                'label' => ' ',
                'class' => Voiture::class,
                'query_builder' => function (VoitureRepository $repo) {
                $currentDate = new \DateTime(); 
                return $repo->createQueryBuilder('v')
                ->leftJoin(VoitureDisponible::class, 'vd', 'WITH', 'vd.Voiture = v')
                ->leftJoin(VoitureNonDisponible::class, 'vnd', 'WITH', 'vnd.idVoiture = v')
                ->addSelect('v') 
                ->groupBy('v.id')
                ->having('MAX(vd.dateDisponible) > MAX(vnd.dateNonDisponible) OR MAX(vnd.dateNonDisponible) IS NULL')
                ->orderBy('v.id', 'DESC');
                },
                'attr' => [
                    'class' => 'form-select'
                ],
                'placeholder' => 'Choisir un voiture...',
                'choice_label' => function (Voiture $voiture) {
                    return $voiture->getVoiture() . ' ' . $voiture->getMatricule();
                },
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => VoitureNonDisponible::class,
        ]);
    }
}
