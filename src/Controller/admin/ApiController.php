<?php
namespace App\Controller\admin;

use App\Entity\Chauffeur;
use App\Repository\GrilleChauffeurRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api',name:'api_api')]
class ApiController extends AbstractController
{
    #[Route('/grille/{id}', name:'_grille', methods:'GET')]
    public function getByGrilleChauffeur(Chauffeur $chauffeur, GrilleChauffeurRepository $grilleChauffeurRepository)
    {
        $grille = $grilleChauffeurRepository->findBy(['Chauffeur' => $chauffeur]);
        return $this->json($grille, 200, [], ['groups' => 'grille:read']);
    }
}