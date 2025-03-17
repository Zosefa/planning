<?php

namespace App\Controller\admin;

use App\Entity\Reservation;
use App\Repository\ChauffeurRepository;
use App\Repository\ReservationRepository;
use App\Repository\TypeReservationRepository;
use App\Repository\VoitureRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted("ROLE_ADMIN")]
#[Route("Admin/suivie-dossier", name: "app_suivie_dossier")]
class SuivieDossier extends AbstractController
{
    #[Route('',name:'')]
    public function list(
        ReservationRepository $reservationRepository,
        Request $request,
        TypeReservationRepository $typeReservationRepository,
        VoitureRepository $voitureRepository,
        ChauffeurRepository $chauffeurRepository):Response
    {
        $user = $this->getUser();
        $reservations = $reservationRepository->findAllDesc();


        if($request->isMethod("POST")){
            $type = $request->request->get("type");
            $voiture = $request->request->get("voiture");
            $chauffeur = $request->request->get("chauffeur");
            $dateDebut = $request->request->get("dateDebut");
            $dateFin =  $request->request->get("dateFin");

            if($type != '' && $voiture != '' && $chauffeur != '' && $dateDebut != '' && $dateFin != ''){
                $typeReservation = $typeReservationRepository->find($type);
                $voitureEntity = $voitureRepository->find($voiture);
                $chauffeurEntity = $chauffeurRepository->find($chauffeur);
                $reservations = $reservationRepository->findByTypeVoitureChauffeurBetweenDate($typeReservation,$voitureEntity,$chauffeurEntity,new \DateTime($dateDebut), new \DateTime($dateFin));
                $this->addFlash('success', 'recherche effectuer!');
            }
            else if($dateDebut != '' && $dateFin != '' && $chauffeur != '' && $type != ''){
                $chauffeurEntity = $chauffeurRepository->find($chauffeur);
                $typeReservation = $typeReservationRepository->find($type);
                $reservations = $reservationRepository->findByChauffeurTypeBetweenDate($chauffeurEntity,$typeReservation,new \DateTime($dateDebut), new \DateTime($dateFin));
                $this->addFlash('success', 'recherche effectuer!');
            }
            else if($dateDebut != '' && $dateFin != '' && $voiture != '' && $type != ''){
                $voitureEntity = $voitureRepository->find($voiture);
                $typeReservation = $typeReservationRepository->find($type);
                $reservations = $reservationRepository->findByVoitureTypeBetweenDate($voitureEntity,$typeReservation,new \DateTime($dateDebut), new \DateTime($dateFin));
                $this->addFlash('success', 'recherche effectuer!');
            }
            else if($dateDebut != '' && $dateFin != '' && $voiture != '' && $chauffeur != ''){
                $voitureEntity = $voitureRepository->find($voiture);
                $chauffeurEntity = $chauffeurRepository->find($chauffeur);
                $reservations = $reservationRepository->findByVoitureChauffeurBetweenDate($voitureEntity,$chauffeurEntity,new \DateTime($dateDebut), new \DateTime($dateFin));
                $this->addFlash('success', 'recherche effectuer!');
            }
            else if($dateDebut != '' && $dateFin != '' && $type != ''){
                $typeReservation = $typeReservationRepository->find($type);
                $reservations = $reservationRepository->findByTypeBetweenDate($typeReservation,new \DateTime($dateDebut), new \DateTime($dateFin));
                $this->addFlash('success', 'recherche effectuer!');
            }
            else if($dateDebut != '' && $dateFin != '' && $voiture != ''){
                $voitureEntity = $voitureRepository->find($voiture);
                $reservations = $reservationRepository->findByVoitureBetweenDate($voitureEntity,new \DateTime($dateDebut), new \DateTime($dateFin));
                $this->addFlash('success', 'recherche effectuer!');
            }
            else if($dateDebut != '' && $dateFin != '' && $chauffeur != ''){
                $chauffeurEntity = $chauffeurRepository->find($chauffeur);
                $reservations = $reservationRepository->findByChauffeurBetweenDate($chauffeurEntity,new \DateTime($dateDebut), new \DateTime($dateFin));
                $this->addFlash('success', 'recherche effectuer!');
            }
            else if($voiture != '' && $chauffeur != ''){
                $voitureEntity = $voitureRepository->find($voiture);
                $chauffeurEntity = $chauffeurRepository->find($chauffeur);
                $reservations = $reservationRepository->findByVoitureChauffeur($voitureEntity,$chauffeurEntity);
                $this->addFlash('success', 'recherche effectuer!');
            }
            else if($voiture != '' && $type != ''){
                $voitureEntity = $voitureRepository->find($voiture);
                $typeReservation = $typeReservationRepository->find($type);
                $reservations = $reservationRepository->findByVoitureType($voitureEntity,$typeReservation);
                $this->addFlash('success', 'recherche effectuer!');
            }
            else if($chauffeur != '' && $type != ''){
                $chauffeurEntity = $chauffeurRepository->find($chauffeur);
                $typeReservation = $typeReservationRepository->find($type);
                $reservations = $reservationRepository->findByChauffeurType($chauffeurEntity,$typeReservation);
                $this->addFlash('success', 'recherche effectuer!');
            }
            else if($chauffeur != '' ){
                $chauffeurEntity = $chauffeurRepository->find($chauffeur);
                $reservations = $reservationRepository->findAllByChauffeur($chauffeurEntity);
                $this->addFlash('success', 'recherche effectuer!');
            }
            else if($type != ''){
                $typeReservation = $typeReservationRepository->find($type);
                $reservations = $reservationRepository->findByType($typeReservation);
                $this->addFlash('success', 'recherche effectuer!');
            }
            else if($voiture != ''){
                $voitureEntity = $voitureRepository->find($voiture);
                $reservations = $reservationRepository->findByVoiture($voitureEntity);
                $this->addFlash('success', 'recherche effectuer!');
            }
            else if($dateDebut != '' && $dateFin != ''){
                $reservations = $reservationRepository->findBetweenDate(new \DateTime($dateDebut), new \DateTime($dateFin));
                $this->addFlash('success', 'recherche effectuer!');
            }
        }

        return $this->render('admin/SuivieDossier/Suivie.html.twig',[
            'reservations' => $reservations,
            'user' => $user,
            'Types' => $typeReservationRepository->findAll(),
            'Voitures' => $voitureRepository->findAll(),
            'Chauffeurs' => $chauffeurRepository->findAll()
        ]);
    }

    #[Route('/{id}',name:'_show')]
    public function show(Reservation $reservations, ReservationRepository $reservationRepository):Response
    {
        $user = $this->getUser();

        $tableau = [$reservations];

        return $this->render('admin/SuivieDossier/Show.html.twig',[
            'reservations' => $tableau,
            'user' => $user
        ]);
    }

    #[Route('/update/{id}', name:'_update')]
    public function update(Reservation $reservation, EntityManagerInterface $em, VoitureRepository $voitureRepository, ChauffeurRepository $chauffeurRepository, Request $request){
        if($request->isMethod('POST')){
            $dateArriver = $request->request->get('dateArriver');
            $dateDepart = $request->request->get('dateDepart');
            $hotel = $request->request->get('hotelArriver');
            $hotelDepart = $request->request->get('hotelDepart');
            $voiture = $voitureRepository->find($request->request->get('voiture'));
            $chauffeur = $chauffeurRepository->find($request->request->get('chauffeur'));

            $reservation
                ->setDateArriver(new DateTime($dateArriver))
                ->setDateDepart(new DateTime($dateDepart))
                ->setHotel($hotel)
                ->setHotelDepart($hotelDepart)
                ->setIdVoiture($voiture)
                ->setChauffeur($chauffeur);

            $em->persist($reservation);
            $em->flush();
            $this->addFlash('success','modification effectuer');
            return $this->redirectToRoute('app_suivie_dossier');
        }
    }
}