<?php
namespace App\Controller\admin;

use App\Repository\ChauffeurRepository;
use App\Repository\ItineraireRepository;
use App\Repository\ReservationRepository;
use App\Repository\VoitureRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_ADMIN')]
#[Route('Admin',name:'app_admin')]
class DashboardController extends AbstractController
{
    #[Route('/', name:'')]
    public function dashboard(Request $request,VoitureRepository $voitureRepository, ChauffeurRepository $chauffeurRepository, ReservationRepository $reservationRepository, ItineraireRepository $itineraireRepository):Response
    {
        $user = $this->getUser();
        $countVoiture = $voitureRepository->count();
        $countChauffeur = $chauffeurRepository->count();
        $countRservation = $reservationRepository->count();

        $dateNow = new \DateTime();
        $year = $dateNow->format('Y');

        $totalVolaMiditra = $reservationRepository->getVolaMiditra($year);
        $totalDepenseAnnuel = $itineraireRepository->getTotalDepenseAnnuel($year);

        $chauffeurPlusReservation = $reservationRepository->getChaufferAvecLePlusReservation($year);
//        dd($chauffeurPlusReservation);

        if($request->isMethod("POST")){
            $daterevenus = $request->request->get("daterevenus");
            $datedepense = $request->request->get("datedepense");
            if($daterevenus != ''){
                $totalVolaMiditra = $reservationRepository->getVolaMiditra($daterevenus);
                $this->addFlash('success','recherche effectuer!');
            }else if($datedepense != ''){
                $totalDepenseAnnuel = $itineraireRepository->getTotalDepenseAnnuel($datedepense);
                $this->addFlash('success','recherche effectuer!');
            }
        }

        return $this->render('admin/Dashboard/Dashboard.html.twig',[
            'user' => $user,
            'countVoiture' => $countVoiture,
            'countChauffeur' => $countChauffeur,
            'countReservation' => $countRservation,
            'totalVolaMiditra' => $totalVolaMiditra,
            'totalDepenseAnnuel' => $totalDepenseAnnuel,
            'chauffeur' => $chauffeurPlusReservation
        ]);
    }
}