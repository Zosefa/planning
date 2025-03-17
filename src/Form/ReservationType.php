<?php

namespace App\Form;

use App\Entity\Chauffeur;
use App\Entity\Client;
use App\Entity\ModePayement;
use App\Entity\Reservation;
use App\Entity\Responsable;
use App\Entity\TypeReservation;
use App\Entity\Voiture;
use App\Entity\VoitureDisponible;
use App\Entity\VoitureNonDisponible;
use App\Repository\VoitureRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ReservationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('dateArriver', null, [
                'label' => 'date arriver des client a ivato',
                'widget' => 'single_text',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'date arriver...'
                ],
                'required' => true,
            ])
            ->add('dateDepart', null, [
                'label' => 'date depart des client a ivato',
                'widget' => 'single_text',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'date depart...'
                ],
                'required' => true,
            ])
            ->add('vol', TextType::class,[
                'label' => ' ',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'vol arriver des clients'
                ],
                'required' => true,
            ])
            ->add('volDepart', TextType::class,[
                'label' => ' ',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'vol depart des clients'
                ],
                'required' => true,
            ])
            ->add('hotel', TextType::class,[
                'label' => ' ',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Hotel pour ramener le client apres recuperation a Aeroport'
                ],
                'required' => true,
            ])
            ->add('HotelDepart', TextType::class,[
                'label' => ' ',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Hotel pour prendre le client pour le ramener a l\'aeropot'
                ],
                'required' => true,
            ])
            ->add('heureDepart', TextType::class, [
                'label' => ' ',
                'required' => true,
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Heure depart du client a ivato'
                ],
            ])
            ->add('heureArriver', TextType::class, [
                'label' => ' ',
                'required' => true,
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Heure arriver du client a ivato'
                ],
            ])
            ->add('heureDepart', TextType::class, [
                'label' => ' ',
                'required' => true,
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Heure Depart du client a ivato'
                ],
            ])
            ->add('prix', NumberType::class,[
                'label' => ' ',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Prix de la reservation...'
                ],
                'required' => true,
            ])
            ->add('NombrePersonne', NumberType::class,[
                'label' => ' ',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Nombre de personne pour la reservation...'
                ],
                'required' => true,
            ])
            ->add('Titulaire',TextType::class,[
                'label' => ' ',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'reservation au nom de...'
                ],
                'required' => true,
            ])
            ->add('idClient', EntityType::class, [
                'label' => ' ',
                'class' => Client::class,
                'choice_label' => 'agence',
                'placeholder' => 'Selectioner l\'agence qui envoie..',
                'attr' => [
                    'class' => 'form-select'
                ],
                'required' => true,
            ])
            ->add('idVoiture', EntityType::class, [
                'label' => ' ',
                'class' => Voiture::class,
                'required' => true,
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
                    return $voiture->getVoiture() . ' ' .' Matriculation : ' . $voiture->getMatricule() . ' ' .'  Place : ' . $voiture->getPlace();
                },
            ])
            ->add('idModePayement', EntityType::class, [
                'label' => ' ',
                'class' => ModePayement::class,
                'choice_label' => 'payement',
                'placeholder' => 'Choisir un mode de payement..',
                'attr' => [
                    'class' => 'form-select'
                ],
                'required' => true,
            ])
            ->add('Chauffeur', EntityType::class, [
                'label' => ' ',
                'required' => false,
                'class' => Chauffeur::class,
                'placeholder' => 'Choisir le chauffeur..',
                'attr' => [
                    'class' => 'form-select'
                ],
                'choice_label' => function (Chauffeur $chauffeur) {
                    return $chauffeur->getIdPersonne()->getNom() . ' ' . $chauffeur->getIdPersonne()->getPrenom() . ' : ' . $chauffeur->getTypeChauffeur()->getTypeChauffeur();
                },
            ])
            ->add('Type', EntityType::class, [
                'label' => ' ',
                'class' => TypeReservation::class,
                'choice_label' => 'type',
                'placeholder' => 'Type de la reservation..',
                'attr' => [
                    'class' => 'form-select'
                ],
                'required' => true,
            ])
            ->add('duree',NumberType::class,[ 
                'label' => ' ',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Duree...'
                ],
                'required' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Reservation::class,
        ]);
    }
}
