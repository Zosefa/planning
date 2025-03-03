<?php
namespace App\Service;

use App\Entity\Personne;
use App\Entity\Telephone;
use Doctrine\ORM\EntityManagerInterface;

class TelephoneService{
    public function __construct(private readonly EntityManagerInterface $em)
    {}

    public function insert(array $data, Personne $personne)
    {
        foreach ($data as $value) {
            $Telephone = new Telephone();
            $Telephone->setNumero($value);
            $Telephone->setIdPersonne($personne);
            $this->em->persist($Telephone);
            $this->em->flush();
        }
    }
}