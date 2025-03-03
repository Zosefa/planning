<?php

namespace App\DataFixtures;

use App\Entity\Personne;
use App\Entity\Responsable;
use App\Entity\Role;
use App\Entity\User;
use App\Repository\PersonneRepository;
use App\Repository\RoleRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    public function __construct(
        private readonly RoleRepository $roleRepository,
        private readonly PersonneRepository $personneRepository,
        private readonly UserPasswordHasherInterface $hasher)
        {}
    public function load(ObjectManager $manager): void
    {
        
        $Role = new Role();
        $Role->setRole('ADMIN');
        $manager->persist($Role);
        $manager->flush();

        $Personne = new Personne();
        $Personne
            ->setNom('RAHERIMANANA')
            ->setPrenom('Toky')
            ->setAdresse('FAIV 410 B');
        $manager->persist($Personne);
        $manager->flush();

        $Reponsable = new Responsable();
        $Reponsable->setIdPersonne($this->personneRepository->find(1));
        $manager->persist($Reponsable);
        $manager->flush();

        $User = new User();
        $User
            ->setUsername('RAHERIMANANA')
            ->setRoles(["ROLE_ADMIN"])
            ->setPassword($this->hasher->hashPassword($User, "000000"))
            ->setIdPersonne($this->personneRepository->find(1));
        $manager->persist($User);
        $manager->flush();
    }
}
