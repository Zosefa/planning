<?php
namespace App\Service;

use App\Entity\Personne;
use App\Entity\Responsable;
use Doctrine\ORM\EntityManagerInterface;

class ResponsableService{
    public function __construct(private readonly EntityManagerInterface $em)
    {}

    public function insert(Personne $personne): Responsable
    {
        $Responsable = new Responsable();
        $Responsable->setIdPersonne($personne);
        $this->em->persist($Responsable);
        $this->em->flush();
        return $Responsable;
    }
}