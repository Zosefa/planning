<?php

namespace App\Entity;

use App\Repository\VoitureDisponibleRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VoitureDisponibleRepository::class)]
class VoitureDisponible
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $dateDisponible = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    #[ORM\JoinColumn(onDelete: "CASCADE")]
    private ?Voiture $Voiture = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateDisponible(): ?\DateTimeInterface
    {
        return $this->dateDisponible;
    }

    public function setDateDisponible(\DateTimeInterface $dateDisponible): static
    {
        $this->dateDisponible = $dateDisponible;

        return $this;
    }

    public function getVoiture(): ?Voiture
    {
        return $this->Voiture;
    }

    public function setVoiture(?Voiture $Voiture): static
    {
        $this->Voiture = $Voiture;

        return $this;
    }
}
