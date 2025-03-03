<?php
namespace App\Controller\chauffeur;

use App\Entity\Reservation;
use App\Repository\ChauffeurRepository;
use App\Repository\ReservationRepository;
use App\Repository\VoitureRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_CHAUFFEUR')]
#[Route('chauffeur', name:'chauffeur')]
class ChauffeurController extends AbstractController
{
    #[Route('',name:'')]
    public function list(ChauffeurRepository $chauffeurRepository,VoitureRepository $voitureRepository, ReservationRepository $reservationRepository):Response
    {
        $user = $this->getUser();
        $personne = $user->getIdPersonne();
        $chauffeur = $chauffeurRepository->findByPersonne($personne)[0];
        $voiture = $voitureRepository->findByChauffeur($chauffeur)[0];

        $reservations = $reservationRepository->findByVoiture($voiture);

        // dd($reservations);

        return $this->render('chauffeur/chauffeur.html.twig',[
            'reservations' => $reservations,
            'user' => $user
        ]);
    }

    #[Route('/reservation/{id}',name:'_show')]
    public function show($id,ChauffeurRepository $chauffeurRepository,VoitureRepository $voitureRepository, ReservationRepository $reservationRepository):Response
    {
        $user = $this->getUser();
        $personne = $user->getIdPersonne();
        $chauffeur = $chauffeurRepository->findByPersonne($personne)[0];
        $voiture = $voitureRepository->findByChauffeur($chauffeur)[0];

        $reservations = $reservationRepository->findByVoitureAndId($voiture,$id);

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