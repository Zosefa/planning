<?php
namespace App\Controller\chauffeur;

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

#[IsGranted('ROLE_CHAUFFEUR')]
#[Route('chauffeur', name:'chauffeur')]
class ChauffeurController extends AbstractController
{
    #[Route('',name:'')]
    public function list(ChauffeurRepository $chauffeurRepository, ReservationRepository $reservationRepository):Response
    {
        $user = $this->getUser(); 
        $personne = $user->getIdPersonne();
        $chauffeur = $chauffeurRepository->findByPersonne($personne)[0];

        $reservations = $reservationRepository->findByChauffeur($chauffeur);

        return $this->render('chauffeur/chauffeur.html.twig',[
            'reservations' => $reservations,    
            'user' => $user
        ]);
    }

    #[Route('/archive',name:'_archive')]
    public function archive(ChauffeurRepository $chauffeurRepository, ReservationRepository $reservationRepository, TypeReservationRepository $typeReservationRepository, Request $request):Response
    {
        $user = $this->getUser(); 
        $personne = $user->getIdPersonne();
        $chauffeur = $chauffeurRepository->findByPersonne($personne)[0];

        $reservations = $reservationRepository->findAllByChauffeur($chauffeur);
        $Types = $typeReservationRepository->findAll();

        if($request->isMethod('POST')){
            $type = $request->request->get('type');
            $debut = $request->request->get('dateDebut');
            $fin = $request->request->get('dateFin');

            if($type != '' && $debut != '' && $fin != ''){
                $typeReservation = $typeReservationRepository->find($type);
                $reservations = $reservationRepository->findByChauffeurAndTypeBetweenDate($chauffeur, $typeReservation, new DateTime($debut), new DateTime($fin));
                $this->addFlash('success' , 'recherche effectuer !');
            }else if($type != ''){
                $typeReservation = $typeReservationRepository->find($type);
                $reservations = $reservationRepository->findByChauffeurAndType($chauffeur, $typeReservation);
                $this->addFlash('success' , 'recherche effectuer !');
            }else if($debut != '' && $fin != ''){
                $reservations = $reservationRepository->findByBewttenDate($chauffeur, new DateTime($debut), new DateTime($fin));
                $this->addFlash('success' , 'recherche effectuer !');
            }

            
        }

        return $this->render('chauffeur/archive.html.twig',[
            'reservations' => $reservations,    
            'user' => $user,
            'types' => $Types
        ]);
    }

    #[Route('/reservation/{id}',name:'_show')]
    public function show($id,ChauffeurRepository $chauffeurRepository, ReservationRepository $reservationRepository):Response
    {
        $user = $this->getUser();
        $personne = $user->getIdPersonne();
        $chauffeur = $chauffeurRepository->findByPersonne($personne)[0];

        $reservations = $reservationRepository->findByChauffeurAndId($chauffeur,$id);

        // dd($reservations);

        return $this->render('chauffeur/show.html.twig',[
            'reservations' => $reservations,
            'user' => $user
        ]);
    }

    #[Route('/effectuer/{id}',name:'_effectuer')]
    public function effectuer(Reservation $reservation, EntityManagerInterface $em){
        $reservation->setStatus(true);
        $em->persist($reservation);
        $em->flush();
        $this->addFlash('success', 'Cette mission est effectuer!');
        return $this->redirectToRoute('chauffeur');
    }
}