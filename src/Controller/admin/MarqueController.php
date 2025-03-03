<?php

namespace App\Controller\admin;

use App\Entity\Marque;
use App\Form\MarqueType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_ADMIN')]
class MarqueController extends AbstractController
{
    public function __construct(private readonly EntityManagerInterface $em)
    {}

    public function insert(): void
    {
        $Marque = new Marque();
        $formMarque = $this->createForm(MarqueType::class, $Marque);
        if($formMarque->isSubmitted() && $formMarque->isValid()){
            $this->em->persist($Marque);
            $this->em->flush();
        }
    }
}