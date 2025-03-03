<?php
namespace App\Controller\admin;

use App\Entity\Marque;
use App\Entity\Voiture;
use App\Form\MarqueType;
use App\Form\VoitureType;
use App\Repository\MarqueRepository;
use App\Repository\VoitureRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_ADMIN')]
#[Route('Admin/voiture', name: 'app_voiture')]
class VoitureController extends AbstractController{
    public function __construct(private readonly DisponibleController $disponibleController)
    {
        
    }


    #[Route('', name:'')]
    public function find(VoitureRepository $voitureRepository, Request $request, EntityManagerInterface $em, MarqueRepository $marqueRepository): Response
    {
        $Voiture = new Voiture();
        $form = $this->createForm(VoitureType::class, $Voiture);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em->persist($Voiture);
            $em->flush();

            $this->disponibleController->insert($Voiture,new \DateTime());
            return $this->redirectToRoute('app_voiture');
        }

        $Marque = new Marque();
        $formMarque = $this->createForm(MarqueType::class, $Marque);
        $formMarque->handleRequest($request);
        if($formMarque->isSubmitted() && $formMarque->isValid()){
            $em->persist($Marque);
            $em->flush();
            $this->addFlash('success', 'Nouveau voiture ajouter !');
            return $this->redirectToRoute('app_voiture');
        }

        $voitures = $voitureRepository->findAllDesc();
        $marques = $marqueRepository->findAll();
        return $this->render('admin/Voiture/Voiture.html.twig',[
            'voitures' => $voitures,
            'form' => $form,
            'formMarque'=> $formMarque,
            'marques' => $marques,
            'user' => $this->getUser() 
        ]);
    }

    #[Route('/delete/{id}',name:'_delete')]
    public function delete(Voiture $voiture,EntityManagerInterface $em){
        $em->remove($voiture);
        $em->flush();
        $this->addFlash('success', 'Voiture supprimer !');
        return $this->redirectToRoute('app_voiture');
    }
}