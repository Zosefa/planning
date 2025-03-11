<?php

namespace App\Entity;

use App\Repository\GrilleChauffeurRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: GrilleChauffeurRepository::class)]
class GrilleChauffeur
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['grille:read'])]
    private ?int $id = null;

    #[ORM\OneToOne(inversedBy: 'grilleChauffeur')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['grille:read'])]
    private ?Chauffeur $Chauffeur = null;

    #[ORM\Column]
    #[Groups(['grille:read'])]
    private ?float $jours = null;

    #[ORM\Column]
    #[Groups(['grille:read'])]
    private ?float $nuit = null;

    #[ORM\Column]
    #[Groups(['grille:read'])]
    private ?float $location = null;

    #[ORM\Column]
    #[Groups(['grille:read'])]
    private ?float $circuit = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getChauffeur(): ?Chauffeur
    {
        return $this->Chauffeur;
    }

    public function setChauffeur(Chauffeur $Chauffeur): static
    {
        $this->Chauffeur = $Chauffeur;

        return $this;
    }

    public function getJours(): ?float
    {
        return $this->jours;
    }

    public function setJours(float $jours): static
    {
        $this->jours = $jours;

        return $this;
    }

    public function getNuit(): ?float
    {
        return $this->nuit;
    }

    public function setNuit(float $nuit): static
    {
        $this->nuit = $nuit;

        return $this;
    }

    public function getLocation(): ?float
    {
        return $this->location;
    }

    public function setLocation(float $location): static
    {
        $this->location = $location;

        return $this;
    }

    public function getCircuit(): ?float
    {
        return $this->circuit;
    }

    public function setCircuit(float $circuit): static
    {
        $this->circuit = $circuit;

        return $this;
    }
}
