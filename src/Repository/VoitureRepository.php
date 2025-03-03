<?php

namespace App\Repository;

use App\Entity\Chauffeur;
use App\Entity\Voiture;
use App\Entity\VoitureDisponible;
use App\Entity\VoitureNonDisponible;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Voiture>
 */
class VoitureRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Voiture::class);
    }

    public function findAllDesc(){
        return $this->createQueryBuilder('v')
        ->orderBy('v.id','DESC')
        ->getQuery()
        ->getResult();
    }

    public function findVoitureValid(\DateTime $currentDate): array
        {
            $qb = $this->createQueryBuilder('v')
            ->leftJoin(VoitureDisponible::class, 'vd', 'WITH', 'vd.Voiture = v')
            ->leftJoin(VoitureNonDisponible::class, 'vnd', 'WITH', 'vnd.idVoiture = v')
            ->addSelect('v')  // Sélectionner uniquement l'entité Voiture
            ->groupBy('v.id')
            ->having('MAX(vd.dateDisponible) > MAX(vnd.dateNonDisponible) OR MAX(vnd.dateNonDisponible) IS NULL')
            ->orderBy('v.id', 'ASC')
            ->getQuery();

            return $qb->getResult();
        }
    
        public function findByChauffeur(Chauffeur $chauffeur){
            return $this->createQueryBuilder('v')
            ->select('v')
            ->where('v.idChauffeur = :chauffeur')
            ->setParameter('chauffeur',$chauffeur)
            ->getQuery()
            ->getResult();
        }

    //    /**
    //     * @return Voiture[] Returns an array of Voiture objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('v')
    //            ->andWhere('v.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('v.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Voiture
    //    {
    //        return $this->createQueryBuilder('v')
    //            ->andWhere('v.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
