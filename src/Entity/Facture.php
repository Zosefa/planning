<?php

namespace App\Entity;

use App\Repository\FactureRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FactureRepository::class)]
class Facture
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $NumeroFacture = null;

    #[ORM\OneToOne(inversedBy: 'facture', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Reservation $Reservation = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $DateFacture = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumeroFacture(): ?string
    {
        return $this->NumeroFacture;
    }

    public function setNumeroFacture(string $NumeroFacture): static
    {
        $this->NumeroFacture = $NumeroFacture;

        return $this;
    }

    public function getReservation(): ?Reservation
    {
        return $this->Reservation;
    }

    public function setReservation(Reservation $Reservation): static
    {
        $this->Reservation = $Reservation;

        return $this;
    }

    public function getDateFacture(): ?\DateTimeInterface
    {
        return $this->DateFacture;
    }

    public function setDateFacture(\DateTimeInterface $DateFacture): static
    {
        $this->DateFacture = $DateFacture;

        return $this;
    }
}
