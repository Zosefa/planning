<?php

namespace App\Controller\admin;

use App\Entity\VoitureNonDisponible;
use App\Form\PanneType;
use App\Repository\VoitureNonDisponibleRepository;
use App\Repository\VoitureRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_ADMIN')]
#[Route('Admin/panne', name: 'app_panne')]
class PanneController extends AbstractController
{

    #[Route('', name: '')]
    public function insert(EntityManagerInterface $em,VoitureNonDisponibleRepository $voitureNonDisponibleRepository,Request $request): Response
    {
        $VoitureNonDisponible = new VoitureNonDisponible();
        $form = $this->createForm(PanneType::class, $VoitureNonDisponible);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em->persist($VoitureNonDisponible);
            $em->flush();
            $this->addFlash('success', 'Voiture en panne Marquer !');
            return $this->redirectToRoute('app_panne');
        }

        $pannes = $voitureNonDisponibleRepository->findAllDesc();
        
        return $this->render('admin/Panne/panne.html.twig',[
            'pannes' => $pannes,
            'form' => $form,
            'user' => $this->getUser()
        ]);
    }
}