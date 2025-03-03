<?php

namespace App\Entity;

use App\Repository\ChauffeurRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ChauffeurRepository::class)]
class Chauffeur
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    #[ORM\JoinColumn(onDelete: "CASCADE")]
    private ?Personne $idPersonne = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?TypeChauffeur $TypeChauffeur = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdPersonne(): ?Personne
    {
        return $this->idPersonne;
    }

    public function setIdPersonne(?Personne $idPersonne): static
    {
        $this->idPersonne = $idPersonne;

        return $this;
    }

    public function getTypeChauffeur(): ?TypeChauffeur
    {
        return $this->TypeChauffeur;
    }

    public function setTypeChauffeur(?TypeChauffeur $TypeChauffeur): static
    {
        $this->TypeChauffeur = $TypeChauffeur;

        return $this;
    }

}
