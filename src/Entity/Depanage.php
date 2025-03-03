<?php

namespace App\Entity;

use App\Repository\DepanageRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DepanageRepository::class)]
class Depanage
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $dateDepanage = null;

    #[ORM\Column]
    private ?float $prixDepanage = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?VoitureNonDisponible $idVoitureNonDisponible = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateDepanage(): ?\DateTimeInterface
    {
        return $this->dateDepanage;
    }

    public function setDateDepanage(\DateTimeInterface $dateDepanage): static
    {
        $this->dateDepanage = $dateDepanage;

        return $this;
    }

    public function getPrixDepanage(): ?float
    {
        return $this->prixDepanage;
    }

    public function setPrixDepanage(float $prixDepanage): static
    {
        $this->prixDepanage = $prixDepanage;

        return $this;
    }

    public function getIdVoitureNonDisponible(): ?VoitureNonDisponible
    {
        return $this->idVoitureNonDisponible;
    }

    public function setIdVoitureNonDisponible(VoitureNonDisponible $idVoitureNonDisponible): static
    {
        $this->idVoitureNonDisponible = $idVoitureNonDisponible;

        return $this;
    }
}
