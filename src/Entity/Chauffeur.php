<?php

namespace App\Entity;

use App\Repository\ChauffeurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: ChauffeurRepository::class)]
class Chauffeur
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['grille:read'])]
    private ?int $id = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    #[ORM\JoinColumn(onDelete: "CASCADE")]
    #[Groups(['grille:read'])]
    private ?Personne $idPersonne = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?TypeChauffeur $TypeChauffeur = null;

    /**
     * @var Collection<int, Reservation>
     */
    #[ORM\OneToMany(targetEntity: Reservation::class, mappedBy: 'Chauffeur')]
    private Collection $reservations;

    #[ORM\OneToOne(mappedBy: 'Chauffeur')]
    private ?GrilleChauffeur $grilleChauffeur = null;

    public function __construct()
    {
        $this->reservations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdPersonne(): ?Personne
    {
        return $this->idPersonne;
    }

    public function setIdPersonne(?Personne $idPersonne): static
    {
        $this->idPersonne = $idPersonne;

        return $this;
    }

    public function getTypeChauffeur(): ?TypeChauffeur
    {
        return $this->TypeChauffeur;
    }

    public function setTypeChauffeur(?TypeChauffeur $TypeChauffeur): static
    {
        $this->TypeChauffeur = $TypeChauffeur;

        return $this;
    }

    /**
     * @return Collection<int, Reservation>
     */
    public function getReservations(): Collection
    {
        return $this->reservations;
    }

    public function addReservation(Reservation $reservation): static
    {
        if (!$this->reservations->contains($reservation)) {
            $this->reservations->add($reservation);
            $reservation->setChauffeur($this);
        }

        return $this;
    }

    public function removeReservation(Reservation $reservation): static
    {
        if ($this->reservations->removeElement($reservation)) {
            // set the owning side to null (unless already changed)
            if ($reservation->getChauffeur() === $this) {
                $reservation->setChauffeur(null);
            }
        }

        return $this;
    }

    public function getGrilleChauffeur(): ?GrilleChauffeur
    {
        return $this->grilleChauffeur;
    }

    public function setGrilleChauffeur(GrilleChauffeur $grilleChauffeur): static
    {
        // set the owning side of the relation if necessary
        if ($grilleChauffeur->getChauffeur() !== $this) {
            $grilleChauffeur->setChauffeur($this);
        }

        $this->grilleChauffeur = $grilleChauffeur;

        return $this;
    }

}
