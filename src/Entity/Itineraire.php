<?php

namespace App\Entity;

use App\Repository\ItineraireRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ItineraireRepository::class)]
class Itineraire
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $lieurDepart = null;

    #[ORM\Column(length: 255)]
    private ?string $lieuArriver = null;

    #[ORM\Column]
    private ?int $cout = null;

    #[ORM\Column]
    private ?int $qte = null;

    #[ORM\Column]
    private ?float $prix = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Reservation $Reservation = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLieurDepart(): ?string
    {
        return $this->lieurDepart;
    }

    public function setLieurDepart(string $lieurDepart): static
    {
        $this->lieurDepart = $lieurDepart;

        return $this;
    }

    public function getLieuArriver(): ?string
    {
        return $this->lieuArriver;
    }

    public function setLieuArriver(string $lieuArriver): static
    {
        $this->lieuArriver = $lieuArriver;

        return $this;
    }

    public function getCout(): ?int
    {
        return $this->cout;
    }

    public function setCout(int $cout): static
    {
        $this->cout = $cout;

        return $this;
    }

    public function getQte(): ?int
    {
        return $this->qte;
    }

    public function setQte(int $qte): static
    {
        $this->qte = $qte;

        return $this;
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

    public function getReservation(): ?Reservation
    {
        return $this->Reservation;
    }

    public function setReservation(?Reservation $Reservation): static
    {
        $this->Reservation = $Reservation;

        return $this;
    }
}
