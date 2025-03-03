<?php

namespace App\Entity;

use App\Repository\TypeChauffeurRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TypeChauffeurRepository::class)]
class TypeChauffeur
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $TypeChauffeur = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTypeChauffeur(): ?string
    {
        return $this->TypeChauffeur;
    }

    public function setTypeChauffeur(string $TypeChauffeur): static
    {
        $this->TypeChauffeur = $TypeChauffeur;

        return $this;
    }
}
