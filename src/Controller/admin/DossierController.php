<?php

namespace App\Controller\admin;

use App\Entity\Client;
use App\Entity\Indemnite;
use App\Entity\Itineraire;
use App\Entity\Nationalite;
use App\Entity\Reservation;
use App\Form\AgenceType;
use App\Form\NationaliteType;
use App\Form\ReservationType;
use App\Repository\ResponsableRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted("ROLE_ADMIN")]
#[Route("Admin/dossier", name: "app_admin_dossier")]
class DossierController extends AbstractController
{
    #[Route('/',name:'')]
    public function dossier(Request $request, EntityManagerInterface $em, ResponsableRepository $responsableRepository): Response
    {

            $Nationalite = new Nationalite();
            $Client = new Client();
            $Reservation = new Reservation();
            $Indemnite = new Indemnite();

            $formNationalite = $this->createForm(NationaliteType::class, $Nationalite);
            $formClient = $this->createForm(AgenceType::class, $Client);
            $formReservation = $this->createForm(ReservationType::class, $Reservation);

            $formNationalite->handleRequest($request);
            $formClient->handleRequest($request);
            $formReservation->handleRequest($request);

            if($formNationalite->isSubmitted() && $formNationalite->isValid()){
                $em->persist($Nationalite);
                $em->flush();
                $this->addFlash('success', 'provenance ajouter');
                return $this->redirectToRoute('app_admin_dossier');
            }

            if($formClient->isSubmitted() && $formClient->isValid()){
                $em->persist($Client);
                $em->flush();
                $this->addFlash('success', 'Agence ajouter');
                return $this->redirectToRoute('app_admin_dossier');
            }

            if($formReservation->isSubmitted() && $formReservation->isValid()){

                $itineraireReservation = json_decode($request->request->get('itineraire_data'),true);


                $personne = $this->getUser()->getIdPersonne();
                $responsable = $responsableRepository->findByPersonne($personne)[0];
                $Reservation->setIdResponsable($responsable);

                $placeDisponible = $formReservation->get('idVoiture')->getData();
                $place = $formReservation->get('NombrePersonne')->getData();

                if($placeDisponible->getPlace() >= $place){
                    $prix = $formReservation->get('prix')->getData();
                    $avance = ($prix * 20 ) / 100;
                    $reste = $prix - $avance;
                    $Reservation
                        ->setStatus(false)
                        ->setAvance($avance)
                        ->setReste($reste);
                    $em->persist($Reservation);
                    $em->flush();

                    $indemniteChauffeur = 0;

                    foreach ($itineraireReservation as $key => $value) {
                        $Itineraire = new Itineraire();
                        $indemniteChauffeur += $value['totalIndemnite'];
                        $Itineraire
                            ->setReservation($Reservation)
                            ->setDescription($value['description'])
                            ->setCout($value['tarif'])
                            ->setQte($value['qte'])
                            ->setPrix($value['total'])
                            ->setCarburant($value['carburant'])
                            ->setDateDebut(new \DateTime($value['datedebut']))
                            ->setDateFin(new \DateTime($value['datefin']))
                            ->setIndemniteChauffeur($value['totalIndemnite']);
                        $em->persist($Itineraire);
                        $em->flush();
                    }


                    if($formReservation->get('Chauffeur')->getData() != ''){
                        $Indemnite
                            ->setIdReservation($Reservation)
                            ->setPrix($indemniteChauffeur)
                            ->setNombreJours($formReservation->get('duree')->getData())
                            ->setIdPayement($formReservation->get('idModePayement')->getData())
                            ->setIdChauffeur($formReservation->get('Chauffeur')->getData());
                        $em->persist($Indemnite);
                        $em->flush();
                    }


                    $this->addFlash('success', 'reservation effectuer');
                    return $this->redirectToRoute('app_admin_dossier');
                }

                $this->addFlash('error', 'place insuffisant');

            }


        return $this->render('admin/Dossier/Dossier.html.twig',[
            'formNationalite' => $formNationalite,
            'formClient' => $formClient,
            'formReservation' => $formReservation,
            'user' => $this->getUser()
        ]);


    }
}