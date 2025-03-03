<?php

namespace App\Controller\admin;

use App\Entity\Voiture;
use App\Entity\VoitureDisponible;
use App\Entity\VoitureNonDisponible;
use App\Form\PanneType;
use App\Repository\VoitureNonDisponibleRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_ADMIN')]
class DisponibleController extends AbstractController
{
    public function __construct(private readonly EntityManagerInterface $em)
    {}

    public function insert(Voiture $voiture, DateTime $date): void
    {
        $VoitureDisponible = new VoitureDisponible();
        $VoitureDisponible
            ->setDateDisponible($date)
            ->setVoiture($voiture);
            $this->em->persist($VoitureDisponible);
            $this->em->flush();
    }
}