<?php

namespace App\Entity;

use App\Repository\ClientRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ClientRepository::class)]
class Client
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $Agence = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Nationalite $IdNationalite = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAgence(): ?string
    {
        return $this->Agence;
    }

    public function setAgence(string $Agence): static
    {
        $this->Agence = $Agence;

        return $this;
    }

    public function getIdNationalite(): ?Nationalite
    {
        return $this->IdNationalite;
    }

    public function setIdNationalite(?Nationalite $IdNationalite): static
    {
        $this->IdNationalite = $IdNationalite;

        return $this;
    }
}
