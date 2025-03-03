<?php

namespace App\Repository;

use App\Entity\Chauffeur;
use App\Entity\Personne;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Chauffeur>
 */
class ChauffeurRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Chauffeur::class);
    }

    public function findAllWithTel(){
        $sql = "
        SELECT ch.id, p.nom, p.prenom, 
            GROUP_CONCAT(t.numero ORDER BY t.numero SEPARATOR ', ') AS numero, 
            p.adresse , tc.type_chauffeur as type
        FROM Chauffeur ch
        LEFT JOIN Personne p ON p.id = ch.id_personne_id
        LEFT JOIN Telephone t ON t.id_personne_id = p.id
        LEFT JOIN type_chauffeur tc ON tc.id = ch.type_chauffeur_id
        GROUP BY ch.id, p.nom, p.prenom, p.adresse
        ORDER BY ch.id DESC
        ";
        $conn = $this->getEntityManager()->getConnection();
        $stmt = $conn->prepare($sql);
        $resultSet = $stmt->executeQuery();
        
        return $resultSet->fetchAllAssociative();
    }

    public function findChauffeursNonAffectes(): array
    {
        return $this->createQueryBuilder('c')
            ->leftJoin('c.idPersonne', 'p')
            ->leftJoin('App\Entity\Voiture', 'v', 'WITH', 'v.idChauffeur = c.id')
            ->where('v.idChauffeur IS NULL')
            ->getQuery()
            ->getResult();
    }

    public function findAllDesc(){
        return $this->createQueryBuilder('c')
        ->orderBy('c.id', 'DESC')
        ->getQuery()
        ->getResult();
    }

    public function findByPersonne(Personne $personne){
        return $this->createQueryBuilder('c')
            ->select('c')
            ->where('c.idPersonne = :personne')
            ->setParameter('personne',$personne)
            ->getQuery()
            ->getResult();
    }

    //    /**
    //     * @return Chauffeur[] Returns an array of Chauffeur objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('c.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Chauffeur
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
