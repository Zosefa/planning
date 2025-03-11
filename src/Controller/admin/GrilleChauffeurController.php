<?php
namespace App\Controller\admin;

use App\Entity\Chauffeur;
use App\Entity\GrilleChauffeur;
use App\Form\GrilleChaffeurType;
use App\Repository\GrilleChauffeurRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_ADMIN')]
#[Route('Admin/Grille-chauffeur', name: 'app_grille')]
class GrilleChauffeurController extends AbstractController
{
    #[Route('',name:'')]
    public function grille(Request $request, EntityManagerInterface $em, GrilleChauffeurRepository $grilleChauffeurRepository): Response
    {
        $grille = new GrilleChauffeur();
        $form = $this->createForm(GrilleChaffeurType::class, $grille);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em->persist($grille);
            $em->flush();
            $this->addFlash('success', 'grille ajouter !');
            return $this->redirectToRoute('app_grille');
        }
        $grilles = $grilleChauffeurRepository->findAll();
        return $this->render('admin/GrilleChauffeur/GrilleChauffeur.html.twig',[
            'user' => $this->getUser(),
            'form' => $form,
            'grilles' => $grilles
        ]); 
    }

    #[Route('/delete/{id}',name: '_delete')]
    public function delete(GrilleChauffeur $grille,EntityManagerInterface $em)
    {
        $em->remove($grille);
        $em->flush();
        $this->addFlash('success', 'Gille Supprimer !');
        return $this->redirectToRoute('app_grille');
    }

    #[Route('/edit/{id}',name:'_edit')]
    public function update(GrilleChauffeur $grille,EntityManagerInterface $em,Request $request)
    {
        if($request->isMethod('POST')){
            $grille
                ->setJours($request->request->get('jours'))
                ->setNuit($request->request->get('nuit'))
                ->setLocation($request->request->get('location'))
                ->setCircuit($request->request->get('circuit'));

            $em->persist($grille);
            $em->flush();
            $this->addFlash('success', 'Grille modifier !');
            return $this->redirectToRoute('app_grille');
        }
        
    }

    
}