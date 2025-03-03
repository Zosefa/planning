<?php

namespace App\Repository;

use App\Entity\Reservation;
use App\Entity\Voiture;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Reservation>
 */
class ReservationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Reservation::class);
    }

    public function findByVoiture(Voiture $voiture){
        return $this->createQueryBuilder('r')
        ->leftJoin('r.itineraire', 'i') 
        ->addSelect('i')
        ->where('r.idVoiture = :voiture')
        ->andWhere('r.status = false')
        ->setParameter('voiture',$voiture)
        ->orderBy('r.dateArriver','ASC')
        ->getQuery()
        ->getResult();
    }

    public function findByVoitureAndId(Voiture $voiture,int $id){
        return $this->createQueryBuilder('r')
        ->leftJoin('r.itineraire', 'i') 
        ->addSelect('i')
        ->where('r.idVoiture = :voiture')
        ->andWhere('r.status = false')
        ->andWhere('r.id = :id')
        ->setParameter('voiture',$voiture)
        ->setParameter('id',$id)
        ->orderBy('r.dateArriver','ASC')
        ->getQuery()
        ->getResult();
    }

    //    /**
    //     * @return Reservation[] Returns an array of Reservation objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('r')
    //            ->andWhere('r.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('r.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Reservation
    //    {
    //        return $this->createQueryBuilder('r')
    //            ->andWhere('r.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
