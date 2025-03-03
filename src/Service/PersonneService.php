<?php
namespace App\Service;

use App\Entity\Personne;
use Doctrine\ORM\EntityManagerInterface;

class PersonneService{
    public function __construct(private readonly EntityManagerInterface $em)
    {}

    public function insert($nom, $prenom, $adresse): Personne
    {
        $personne = new Personne();
        $personne->setNom($nom);
        $personne->setPrenom($prenom);
        $personne->setAdresse($adresse);
        $this->em->persist($personne);
        $this->em->flush();
        return $personne;
    }
}