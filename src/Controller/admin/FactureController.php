<?php

namespace App\Controller\admin;

use App\Entity\Reservation;
use App\Repository\FactureRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_ADMIN')]
#[Route('/admin/facture', name:'app_admin_facture')]
class FactureController extends AbstractController
{
    #[Route('/{id}', name:'')]
    public function generate(Reservation $reservation, FactureRepository $factureRepository):Response
    {
        $facture = $factureRepository->findBy(['Reservation' => $reservation])[0];

        return $this->render('admin/Facture.html.twig',[
            'facture' => $facture
        ]);
    }
}