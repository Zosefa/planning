<?php

namespace App\Entity;

use App\Repository\VoitureRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VoitureRepository::class)]
class Voiture
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)] 
    private ?string $voiture = null;

    #[ORM\Column(length: 255)]
    private ?string $matricule = null;

    #[ORM\Column]
    private ?int $place = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Marque $idMarque = null;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getVoiture(): ?string
    {
        return $this->voiture;
    }

    public function setVoiture(string $voiture): static
    {
        $this->voiture = $voiture;

        return $this;
    }

    public function getMatricule(): ?string
    {
        return $this->matricule;
    }

    public function setMatricule(string $matricule): static
    {
        $this->matricule = $matricule;

        return $this;
    }

    public function getPlace(): ?int
    {
        return $this->place;
    }

    public function setPlace(int $place): static
    {
        $this->place = $place;

        return $this;
    }

    public function getIdMarque(): ?Marque
    {
        return $this->idMarque;
    }

    public function setIdMarque(?Marque $idMarque): static
    {
        $this->idMarque = $idMarque;

        return $this;
    }
}
