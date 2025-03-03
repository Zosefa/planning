<?php
namespace App\Controller\admin;

use App\Entity\Personne;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_ADMIN')]
class RegisterController extends AbstractController
{
    public function __construct(
        private readonly EntityManagerInterface $em,
        private readonly UserPasswordHasherInterface $hasher
    )
    {}

    public function register(Personne $personne,String $role)
    {
        $User = new User();
        $User
            ->setUsername($personne->getNom())
            ->setPassword($this->hasher->hashPassword($User, '000000'))
            ->setIdPersonne($personne)
            ->setRoles(["ROLE_".$role]);
        $this->em->persist($User);
        $this->em->flush();
    }
}