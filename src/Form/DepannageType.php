<?php

namespace App\Form;

use App\Entity\Depanage;
use App\Entity\VoitureDisponible;
use App\Entity\VoitureNonDisponible;
use App\Repository\VoitureNonDisponibleRepository;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DepannageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('dateDepanage', null, [ 
                'widget' => 'single_text',
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('prixDepanage',NumberType::class,[
                'label' => ' ',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'prix du depannage'
                ]
            ])
            ->add('idVoitureNonDisponible', EntityType::class, [
                'label' => ' ',
                'class' => VoitureNonDisponible::class,
                'choice_label' => 'IdVoiture.voiture',
                'query_builder' => function (VoitureNonDisponibleRepository $repo) {
                $currentDate = new \DateTime(); 
                return $repo->createQueryBuilder('v')
                ->leftJoin(VoitureDisponible::class, 'vd', 'WITH', 'vd.Voiture = v.idVoiture')
                ->addSelect('v') 
                ->groupBy('v.id')
                ->having('MAX(vd.dateDisponible) < MAX(v.dateNonDisponible)')
                ->orderBy('v.id', 'DESC');
                },
                'attr' => [
                    'class' => 'form-select'
                ],
                'placeholder' => 'voiture a reparer...',
                'choice_label' => function (VoitureNonDisponible $voiture) {
                    return $voiture->getIdVoiture()->getVoiture() . ' ' . $voiture->getIdVoiture()->getMatricule();
                },
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Depanage::class,
        ]);
    }
}
