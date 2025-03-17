<?php

namespace App\Entity;

use App\Repository\ReservationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ReservationRepository::class)]
class Reservation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $dateArriver = null;

    #[ORM\Column(length: 255)] 
    private ?string $heureArriver = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $dateDepart = null;

    #[ORM\Column(length: 255)] 
    private ?string $heureDepart = null;

    #[ORM\Column(length: 255)] 
    private ?string $vol = null;

    #[ORM\Column(length: 255)] 
    private ?string $hotel = null;

    #[ORM\Column]
    private ?float $prix = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Client $idClient = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Voiture $idVoiture = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Responsable $idResponsable = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?ModePayement $idModePayement = null;

    #[ORM\Column]
    private ?int $NombrePersonne = null;

    #[ORM\Column(length: 255)]
    private ?string $Titulaire = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?TypeReservation $Type = null;

    #[ORM\Column]
    private ?int $duree = null;

    #[ORM\OneToMany(mappedBy: 'Reservation', targetEntity: Itineraire::class, orphanRemoval: true)]
    private Collection $itineraire;

    #[ORM\Column]
    private ?bool $status = null;

    #[ORM\Column(length: 255)]
    private ?string $volDepart = null;

    #[ORM\Column(length: 255)]
    private ?string $HotelDepart = null;

    #[ORM\OneToOne(mappedBy: 'Reservation', cascade: ['persist', 'remove'])]
    private ?Facture $facture = null;

    #[ORM\Column]
    private ?float $avance = null; 

    #[ORM\Column]
    private ?float $reste = null;

    #[ORM\ManyToOne(inversedBy: 'reservations')]
    private ?Chauffeur $Chauffeur = null;

    public function __construct()
    {
        $this->itineraire = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateArriver(): ?\DateTimeInterface
    {
        return $this->dateArriver;
    }

    public function setDateArriver(\DateTimeInterface $dateArriver): static
    {
        $this->dateArriver = $dateArriver;

        return $this;
    }

    public function getDateDepart(): ?\DateTimeInterface
    {
        return $this->dateDepart;
    }

    public function setDateDepart(\DateTimeInterface $dateDepart): static
    {
        $this->dateDepart = $dateDepart;

        return $this;
    }

    public function getHeureArriver(): ?string
    {
        return $this->heureArriver;
    }

    public function setHeureArriver(string $heureArriver): static
    {
        $this->heureArriver = $heureArriver;

        return $this;
    }

    public function getHeureDepart(): ?String
    {
        return $this->heureDepart;
    }

    public function setHeureDepart(string $heureDepart): static
    {
        $this->heureDepart = $heureDepart;

        return $this;
    }

    public function getVol(): ?String
    {
        return $this->vol;
    }

    public function setVol(string $vol): static
    {
        $this->vol = $vol;

        return $this;
    }

    public function getHotel(): ?String
    {
        return $this->hotel;
    }

    public function setHotel(string $hotel): static
    {
        $this->hotel = $hotel;

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

    public function getIdClient(): ?Client
    {
        return $this->idClient;
    }

    public function setIdClient(?Client $idClient): static
    {
        $this->idClient = $idClient;

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

    public function getIdResponsable(): ?Responsable
    {
        return $this->idResponsable;
    }

    public function setIdResponsable(?Responsable $idResponsable): static
    {
        $this->idResponsable = $idResponsable;

        return $this;
    }

    public function getIdModePayement(): ?ModePayement
    {
        return $this->idModePayement;
    }

    public function setIdModePayement(?ModePayement $idModePayement): static
    {
        $this->idModePayement = $idModePayement;

        return $this;
    }

    public function getNombrePersonne(): ?int
    {
        return $this->NombrePersonne;
    }

    public function setNombrePersonne(int $NombrePersonne): static
    {
        $this->NombrePersonne = $NombrePersonne;

        return $this;
    }

    public function getTitulaire(): ?string
    {
        return $this->Titulaire;
    }

    public function setTitulaire(string $Titulaire): static
    {
        $this->Titulaire = $Titulaire;

        return $this;
    }

    public function getType(): ?TypeReservation
    {
        return $this->Type;
    }

    public function setType(?TypeReservation $Type): static
    {
        $this->Type = $Type;

        return $this;
    }

    public function getDuree(): ?int
    {
        return $this->duree;
    }

    public function setDuree(int $duree): static
    {
        $this->duree = $duree;

        return $this;
    }

    public function getItineraire(): Collection
{
    return $this->itineraire;
}

public function addItineraire(Itineraire $itineraire): static
{
    if (!$this->itineraire->contains($itineraire)) {
        $this->itineraire->add($itineraire);
        $itineraire->setReservation($this);
    } 
    return $this;
}

public function removeItineraire(Itineraire $itineraire): static
{
    if ($this->itineraire->removeElement($itineraire)) {
        // Set the owning side to null (unless already changed)
        if ($itineraire->getReservation() === $this) {
            $itineraire->setReservation(null);
        }
    }
    return $this;
}

public function isStatus(): ?bool
{
    return $this->status;
}

public function setStatus(bool $status): static
{
    $this->status = $status;

    return $this;
}

public function getVolDepart(): ?string
{
    return $this->volDepart;
}

public function setVolDepart(string $volDepart): static
{
    $this->volDepart = $volDepart;

    return $this;
}

public function getHotelDepart(): ?string
{
    return $this->HotelDepart;
}

public function setHotelDepart(string $HotelDepart): static
{
    $this->HotelDepart = $HotelDepart;

    return $this;
}

public function getFacture(): ?Facture
{
    return $this->facture;
}

public function setFacture(Facture $facture): static
{
    // set the owning side of the relation if necessary
    if ($facture->getReservation() !== $this) {
        $facture->setReservation($this);
    }

    $this->facture = $facture;

    return $this;
}

public function getAvance(): ?float
{
    return $this->avance;
}

public function setAvance(float $avance): static
{
    $this->avance = $avance;

    return $this;
}

public function getReste(): ?float
{
    return $this->reste;
}

public function setReste(float $reste): static
{
    $this->reste = $reste;

    return $this;
}

public function getChauffeur(): ?Chauffeur
{
    return $this->Chauffeur;
}

public function setChauffeur(?Chauffeur $Chauffeur): static
{
    $this->Chauffeur = $Chauffeur;

    return $this;
}
}
