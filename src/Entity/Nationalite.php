<?php

namespace App\Entity;

use App\Repository\NationaliteRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: NationaliteRepository::class)]
class Nationalite
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $Nationalite = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNationalite(): ?string
    {
        return $this->Nationalite;
    }

    public function setNationalite(string $Nationalite): static
    {
        $this->Nationalite = $Nationalite;

        return $this;
    }
}
