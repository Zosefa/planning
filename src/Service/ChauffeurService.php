<?php
namespace App\Service;

use App\Entity\Chauffeur;
use App\Entity\Personne;
use App\Entity\TypeChauffeur;
use Doctrine\ORM\EntityManagerInterface;

class ChauffeurService{
    public function __construct(private readonly EntityManagerInterface $em)
    {}

    public function insert(Personne $personne, TypeChauffeur $typeChauffeur): Chauffeur
    {
        $Chauffeur = new Chauffeur();
        $Chauffeur
        ->setIdPersonne($personne)
        ->setTypeChauffeur($typeChauffeur);
        $this->em->persist($Chauffeur);
        $this->em->flush();
        return $Chauffeur;
    }
}