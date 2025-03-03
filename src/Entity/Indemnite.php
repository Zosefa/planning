<?php

namespace App\Entity;

use App\Repository\IndemniteRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: IndemniteRepository::class)]
class Indemnite
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?float $prix = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Chauffeur $idChauffeur = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Reservation $idReservation = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?ModePayement $IdPayement = null;

    #[ORM\Column]
    private ?float $Journalier = null;

    #[ORM\Column]
    private ?int $nombreJours = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(float $prix): static
    {
        $this->prix = $prix;

        return $this;
    }

    public function getIdChauffeur(): ?Chauffeur
    {
        return $this->idChauffeur;
    }

    public function setIdChauffeur(?Chauffeur $idChauffeur): static
    {
        $this->idChauffeur = $idChauffeur;

        return $this;
    }

    public function getIdReservation(): ?Reservation
    {
        return $this->idReservation;
    }

    public function setIdReservation(?Reservation $idReservation): static
    {
        $this->idReservation = $idReservation;

        return $this;
    }

    public function getIdPayement(): ?ModePayement
    {
        return $this->IdPayement;
    }

    public function setIdPayement(?ModePayement $IdPayement): static
    {
        $this->IdPayement = $IdPayement;

        return $this;
    }

    public function getJournalier(): ?float
    {
        return $this->Journalier;
    }

    public function setJournalier(float $Journalier): static
    {
        $this->Journalier = $Journalier;

        return $this;
    }

    public function getNombreJours(): ?int
    {
        return $this->nombreJours;
    }

    public function setNombreJours(int $nombreJours): static
    {
        $this->nombreJours = $nombreJours;

        return $this;
    }
}
