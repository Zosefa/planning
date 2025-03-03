<?php

namespace App\Entity;

use App\Repository\VoitureNonDisponibleRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VoitureNonDisponibleRepository::class)]
class VoitureNonDisponible
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $dateNonDisponible = null;

    #[ORM\Column(length: 2000)]
    private ?string $Motif = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Voiture $idVoiture = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateNonDisponible(): ?\DateTimeInterface
    {
        return $this->dateNonDisponible;
    }

    public function setDateNonDisponible(\DateTimeInterface $dateNonDisponible): static
    {
        $this->dateNonDisponible = $dateNonDisponible;

        return $this;
    }

    public function getMotif(): ?string
    {
        return $this->Motif;
    }

    public function setMotif(string $Motif): static
    {
        $this->Motif = $Motif;

        return $this;
    }

    public function getIdVoiture(): ?Voiture
    {
        return $this->idVoiture;
    }

    public function setIdVoiture(?Voiture $idVoiture): static
    {
        $this->idVoiture = $idVoiture;

        return $this;
    }
}
