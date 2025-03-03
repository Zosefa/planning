<?php

namespace App\Entity;

use App\Repository\ModePayementRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ModePayementRepository::class)]
class ModePayement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $payement = null;

    #[ORM\Column]
    private ?bool $allPayement = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPayement(): ?string
    {
        return $this->payement;
    }

    public function setPayement(string $payement): static
    {
        $this->payement = $payement;

        return $this;
    }

    public function isAllPayement(): ?bool
    {
        return $this->allPayement;
    }

    public function setAllPayement(bool $allPayement): static
    {
        $this->allPayement = $allPayement;

        return $this;
    }
}
