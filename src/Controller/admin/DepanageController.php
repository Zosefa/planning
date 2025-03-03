<?php

namespace App\Controller\admin;

use App\Entity\Depanage;
use App\Form\DepannageType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_ADMIN')]
#[Route('Admin/depanage', name: 'app_depannage')]
class DepanageController extends AbstractController
{
    public function __construct(private readonly DisponibleController $disponibleController)
    {} 

    #[Route('', name: '')]
    public function insert(EntityManagerInterface $em,Request $request): Response
    {
        $Depanage = new Depanage();
        $form = $this->createForm(DepannageType::class, $Depanage);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em->persist($Depanage);
            $em->flush();
            // $data = $form->all();
            $voitureNonDisponible = $form->get('idVoitureNonDisponible')->getData();
            $dateDepanage = $form->get('dateDepanage')->getData();
            $voiture = $voitureNonDisponible->getIdVoiture();
            $this->disponibleController->insert($voiture, $dateDepanage);
            $this->addFlash('success', 'Depannage Enregistrer !');
            return $this->redirectToRoute('app_depannage');
        }
        
        return $this->render('admin/Depanage/depanage.html.twig',[
            'form' => $form ,
            'user' => $this->getUser()
        ]);
    }
}