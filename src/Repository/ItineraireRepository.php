<?php

namespace App\Repository;

use App\Entity\Itineraire;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Itineraire>
 */
class ItineraireRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Itineraire::class);
    }

    public function getTotalDepenseAnnuel(String $annee){
        $sql = "WITH mois AS (
    SELECT 1 AS mois_num, 'Janvier' AS mois_nom UNION ALL
    SELECT 2, 'Février' UNION ALL
    SELECT 3, 'Mars' UNION ALL
    SELECT 4, 'Avril' UNION ALL
    SELECT 5, 'Mai' UNION ALL
    SELECT 6, 'Juin' UNION ALL
    SELECT 7, 'Juillet' UNION ALL
    SELECT 8, 'Août' UNION ALL
    SELECT 9, 'Septembre' UNION ALL
    SELECT 10, 'Octobre' UNION ALL
    SELECT 11, 'Novembre' UNION ALL
    SELECT 12, 'Décembre'
)
SELECT
    m.mois_nom AS mois,
    COALESCE(SUM(i.carburant + i.indemnite_chauffeur), 0) + COALESCE(SUM(d.prix_depanage), 0) AS total_depense
FROM mois m
         LEFT JOIN itineraire i ON MONTH(i.date_debut) = m.mois_num AND YEAR(i.date_debut) = :annee
    LEFT JOIN depanage d ON MONTH(d.date_depanage) = m.mois_num AND YEAR(d.date_depanage) = :annee
GROUP BY m.mois_num, m.mois_nom
ORDER BY m.mois_num";

        $conn = $this->getEntityManager()->getConnection();
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':annee', $annee, \Doctrine\DBAL\Types\Types::INTEGER);
        $resultSet = $stmt->executeQuery();

        return $resultSet->fetchAllAssociative();
    }

    //    /**
    //     * @return Itineraire[] Returns an array of Itineraire objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('i')
    //            ->andWhere('i.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('i.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Itineraire
    //    {
    //        return $this->createQueryBuilder('i')
    //            ->andWhere('i.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
