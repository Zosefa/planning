<?php

namespace App\Repository;

use App\Entity\Personne;
use App\Entity\Responsable;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Responsable>
 */
class ResponsableRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Responsable::class);
    }

    public function findAllWithTel(){
        $sql = "
        SELECT r.id, p.nom, p.prenom, 
            GROUP_CONCAT(t.numero ORDER BY t.numero SEPARATOR ', ') AS numero, 
            p.adresse 
        FROM Responsable r
        LEFT JOIN Personne p ON p.id = r.id_personne_id
        LEFT JOIN Telephone t ON t.id_personne_id = p.id
        GROUP BY r.id, p.nom, p.prenom, p.adresse
        ";
        $conn = $this->getEntityManager()->getConnection();
        $stmt = $conn->prepare($sql);
        $resultSet = $stmt->executeQuery();
        
        return $resultSet->fetchAllAssociative();
    }

    public function findByPersonne(Personne $personne)
    {
        return $this->createQueryBuilder('r')
            ->where('r.idPersonne = :personne')
            ->setParameter('personne',$personne)
            ->getQuery()
            ->getResult();
    }

    //    /**
    //     * @return Responsable[] Returns an array of Responsable objects
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

    //    public function findOneBySomeField($value): ?Responsable
    //    {
    //        return $this->createQueryBuilder('r')
    //            ->andWhere('r.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
