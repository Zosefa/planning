<?php

namespace App\Repository;

use App\Entity\Chauffeur;
use App\Entity\Reservation;
use App\Entity\TypeReservation;
use App\Entity\Voiture;
use DateTime;
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

    public function findAllDesc(){
        return $this->createQueryBuilder('r')
            ->leftJoin('r.itineraire', 'i')
            ->addSelect('i')
            ->orderBy('r.id','DESC')
            ->getQuery()
            ->getResult();
    }

    public function findByChauffeur(Chauffeur $chauffeur){
        return $this->createQueryBuilder('r')
        ->leftJoin('r.itineraire', 'i') 
        ->addSelect('i')
        ->where('r.Chauffeur = :chauffeur')
        ->andWhere('r.status = false')
        ->setParameter('chauffeur',$chauffeur)
        ->orderBy('r.dateArriver','ASC')
        ->getQuery()
        ->getResult();
    }

    public function findByChauffeurAndType(Chauffeur $chauffeur, TypeReservation $type){
        return $this->createQueryBuilder('r')
        ->leftJoin('r.itineraire', 'i') 
        ->addSelect('i')
        ->where('r.Chauffeur = :chauffeur')
        ->andWhere('r.Type = :type')
        ->setParameter('chauffeur',$chauffeur)
        ->setParameter('type',$type)
        ->orderBy('r.id','DESC')
        ->getQuery()
        ->getResult();
    }

    public function findByBewttenDate(Chauffeur $chauffeur, DateTime $debut, DateTime $fin){
        return $this->createQueryBuilder('r')
        ->leftJoin('r.itineraire', 'i') 
        ->addSelect('i')
        ->where('r.Chauffeur = :chauffeur')
        ->andWhere('r.dateArriver BETWEEN :debut AND :fin')
        ->setParameter('chauffeur',$chauffeur)
        ->setParameter('debut', $debut)
        ->setParameter('fin', $fin)
        ->orderBy('r.id','DESC')
        ->getQuery()
        ->getResult();
    }

    public function findByChauffeurAndTypeBetweenDate(Chauffeur $chauffeur, TypeReservation $type, DateTime $debut, DateTime $fin){
        return $this->createQueryBuilder('r')
        ->leftJoin('r.itineraire', 'i') 
        ->addSelect('i')
        ->where('r.Chauffeur = :chauffeur')
        ->andWhere('r.Type = :type')
        ->andWhere('r.dateArriver BETWEEN :debut AND :fin')
        ->setParameter('chauffeur',$chauffeur)
        ->setParameter('type',$type)
        ->setParameter('debut', $debut)
        ->setParameter('fin', $fin)
        ->orderBy('r.id','DESC')
        ->getQuery()
        ->getResult();
    }

    public function findAllByChauffeur(Chauffeur $chauffeur){
        return $this->createQueryBuilder('r')
        ->leftJoin('r.itineraire', 'i') 
        ->addSelect('i')
        ->where('r.Chauffeur = :chauffeur')
        ->setParameter('chauffeur',$chauffeur)
        ->orderBy('r.id','DESC')
        ->getQuery()
        ->getResult();
    }

    public function findByChauffeurAndId(Chauffeur $chauffeur,int $id){
        return $this->createQueryBuilder('r')
        ->leftJoin('r.itineraire', 'i') 
        ->addSelect('i')
        ->where('r.Chauffeur = :chauffeur')
        ->andWhere('r.id = :id')
        ->setParameter('chauffeur',$chauffeur)
        ->setParameter('id',$id)
        ->orderBy('r.dateArriver','ASC')
        ->getQuery()
        ->getResult();
    }


    public function findByTypeVoitureChauffeurBetweenDate(
        TypeReservation $typeReservation,
        Voiture $voiture,
        Chauffeur $chauffeur,
        DateTime $dateDebut,
        DateTime $dateFin
    ){
        return $this->createQueryBuilder('r')
            ->leftJoin('r.itineraire', 'i')
            ->addSelect('i')
            ->where('r.Chauffeur = :chauffeur')
            ->andWhere('r.Type = :type')
            ->andWhere('r.idVoiture = :voiture')
            ->andWhere('r.dateArriver BETWEEN :debut AND :fin')
            ->setParameter('chauffeur',$chauffeur)
            ->setParameter('voiture',$voiture)
            ->setParameter('type',$typeReservation)
            ->setParameter('debut', $dateDebut)
            ->setParameter('fin', $dateFin)
            ->orderBy('r.id','DESC')
            ->getQuery()
            ->getResult();
    }


    public function findByTypeBetweenDate(
        TypeReservation $typeReservation,
        DateTime $dateDebut,
        DateTime $dateFin
    ){
        return $this->createQueryBuilder('r')
            ->leftJoin('r.itineraire', 'i')
            ->addSelect('i')
            ->where('r.Type = :type')
            ->andWhere('r.dateArriver BETWEEN :debut AND :fin')
            ->setParameter('type',$typeReservation)
            ->setParameter('debut', $dateDebut)
            ->setParameter('fin', $dateFin)
            ->orderBy('r.id','DESC')
            ->getQuery()
            ->getResult();
    }

    public function findByVoitureBetweenDate(
        Voiture $voiture,
        DateTime $dateDebut,
        DateTime $dateFin
    ){
        return $this->createQueryBuilder('r')
            ->leftJoin('r.itineraire', 'i')
            ->addSelect('i')
            ->where('r.idVoiture = :voiture')
            ->andWhere('r.dateArriver BETWEEN :debut AND :fin')
            ->setParameter('voiture',$voiture)
            ->setParameter('debut', $dateDebut)
            ->setParameter('fin', $dateFin)
            ->orderBy('r.id','DESC')
            ->getQuery()
            ->getResult();
    }

    public function findByChauffeurBetweenDate(
        Chauffeur $chauffeur,
        DateTime $dateDebut,
        DateTime $dateFin
    ){
        return $this->createQueryBuilder('r')
            ->leftJoin('r.itineraire', 'i')
            ->addSelect('i')
            ->where('r.Chauffeur = :chauffeur')
            ->andWhere('r.dateArriver BETWEEN :debut AND :fin')
            ->setParameter('chauffeur',$chauffeur)
            ->setParameter('debut', $dateDebut)
            ->setParameter('fin', $dateFin)
            ->orderBy('r.id','DESC')
            ->getQuery()
            ->getResult();
    }

    public function findByChauffeurTypeBetweenDate(
        Chauffeur $chauffeur,
        TypeReservation $typeReservation,
        DateTime $dateDebut,
        DateTime $dateFin
    ){
        return $this->createQueryBuilder('r')
            ->leftJoin('r.itineraire', 'i')
            ->addSelect('i')
            ->where('r.Chauffeur = :chauffeur')
            ->andWhere('r.Type = :type')
            ->andWhere('r.dateArriver BETWEEN :debut AND :fin')
            ->setParameter('chauffeur',$chauffeur)
            ->setParameter('type',$typeReservation)
            ->setParameter('debut', $dateDebut)
            ->setParameter('fin', $dateFin)
            ->orderBy('r.id','DESC')
            ->getQuery()
            ->getResult();
    }

    public function findByVoitureTypeBetweenDate(
        Voiture $voiture,
        TypeReservation $typeReservation,
        DateTime $dateDebut,
        DateTime $dateFin
    ){
        return $this->createQueryBuilder('r')
            ->leftJoin('r.itineraire', 'i')
            ->addSelect('i')
            ->where('r.idVoiture = :voiture')
            ->andWhere('r.Type = :type')
            ->andWhere('r.dateArriver BETWEEN :debut AND :fin')
            ->setParameter('voiture',$voiture)
            ->setParameter('type',$typeReservation)
            ->setParameter('debut', $dateDebut)
            ->setParameter('fin', $dateFin)
            ->orderBy('r.id','DESC')
            ->getQuery()
            ->getResult();
    }

    public function findByVoitureChauffeurBetweenDate(
        Voiture $voiture,
        Chauffeur $chauffeur,
        DateTime $dateDebut,
        DateTime $dateFin
    ){
        return $this->createQueryBuilder('r')
            ->leftJoin('r.itineraire', 'i')
            ->addSelect('i')
            ->where('r.idVoiture = :voiture')
            ->andWhere('r.Chauffeur = :chauffeur')
            ->andWhere('r.dateArriver BETWEEN :debut AND :fin')
            ->setParameter('voiture',$voiture)
            ->setParameter('chauffeur',$chauffeur)
            ->setParameter('debut', $dateDebut)
            ->setParameter('fin', $dateFin)
            ->orderBy('r.id','DESC')
            ->getQuery()
            ->getResult();
    }

    public function findBetweenDate(
        DateTime $dateDebut,
        DateTime $dateFin
    ){
        return $this->createQueryBuilder('r')
            ->leftJoin('r.itineraire', 'i')
            ->addSelect('i')
            ->where('r.dateArriver BETWEEN :debut AND :fin')
            ->setParameter('debut', $dateDebut)
            ->setParameter('fin', $dateFin)
            ->orderBy('r.id','DESC')
            ->getQuery()
            ->getResult();
    }

    public function findByVoitureChauffeur(
        Voiture $voiture,
        Chauffeur $chauffeur
    ){
        return $this->createQueryBuilder('r')
            ->leftJoin('r.itineraire', 'i')
            ->addSelect('i')
            ->where('r.idVoiture = :voiture')
            ->andWhere('r.Chauffeur = :chauffeur')
            ->setParameter('voiture',$voiture)
            ->setParameter('chauffeur',$chauffeur)
            ->orderBy('r.id','DESC')
            ->getQuery()
            ->getResult();
    }

    public function findByVoitureType(
        Voiture $voiture,
        TypeReservation $typeReservation
    ){
        return $this->createQueryBuilder('r')
            ->leftJoin('r.itineraire', 'i')
            ->addSelect('i')
            ->where('r.idVoiture = :voiture')
            ->andWhere('r.Type = :type')
            ->setParameter('voiture',$voiture)
            ->setParameter('type',$typeReservation)
            ->orderBy('r.id','DESC')
            ->getQuery()
            ->getResult();
    }

    public function findByVoiture(
        Voiture $voiture
    ){
        return $this->createQueryBuilder('r')
            ->leftJoin('r.itineraire', 'i')
            ->addSelect('i')
            ->where('r.idVoiture = :voiture')
            ->setParameter('voiture',$voiture)
            ->orderBy('r.id','DESC')
            ->getQuery()
            ->getResult();
    }

    public function findByChauffeurType(
        Chauffeur $chauffeur,
        TypeReservation $typeReservation
    ){
        return $this->createQueryBuilder('r')
            ->leftJoin('r.itineraire', 'i')
            ->addSelect('i')
            ->where('r.Chauffeur = :chauffeur')
            ->andWhere('r.Type = :type')
            ->setParameter('chauffeur',$chauffeur)
            ->setParameter('type',$typeReservation)
            ->orderBy('r.id','DESC')
            ->getQuery()
            ->getResult();
    }

    public function findByType(
        TypeReservation $typeReservation
    ){
        return $this->createQueryBuilder('r')
            ->leftJoin('r.itineraire', 'i')
            ->addSelect('i')
            ->where('r.Type = :type')
            ->setParameter('type',$typeReservation)
            ->orderBy('r.id','DESC')
            ->getQuery()
            ->getResult();
    }

    public function findByAllChauffeur(
        Chauffeur $chauffeur
    ){
        return $this->createQueryBuilder('r')
            ->leftJoin('r.itineraire', 'i')
            ->addSelect('i')
            ->where('r.Chauffeur = :chauffeur')
            ->setParameter('chauffeur',$chauffeur)
            ->orderBy('r.id','DESC')
            ->getQuery()
            ->getResult();
    }

    public function getVolaMiditra(String $annee){
        $sql = "SELECT
            m.mois,
            m.mois_nom,
            IFNULL(SUM(r.prix), 0) AS total_prix
        FROM
            (SELECT 1 AS mois, 'janvier' AS mois_nom UNION ALL
             SELECT 2, 'février' UNION ALL
             SELECT 3, 'mars' UNION ALL
             SELECT 4, 'avril' UNION ALL
             SELECT 5, 'mai' UNION ALL
             SELECT 6, 'juin' UNION ALL
             SELECT 7, 'juillet' UNION ALL
             SELECT 8, 'août' UNION ALL
             SELECT 9, 'septembre' UNION ALL
             SELECT 10, 'octobre' UNION ALL
             SELECT 11, 'novembre' UNION ALL
             SELECT 12, 'décembre') AS m
                LEFT JOIN reservation r
                          ON m.mois = MONTH(r.date_arriver)
            AND YEAR(r.date_arriver) = :annee
        GROUP BY m.mois, m.mois_nom
        ORDER BY m.mois";
        $conn = $this->getEntityManager()->getConnection();
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':annee', $annee, \Doctrine\DBAL\Types\Types::INTEGER);
        $resultSet = $stmt->executeQuery();

        return $resultSet->fetchAllAssociative();
    }

    public function getChaufferAvecLePlusReservation(String $annee){
        $sql = "SELECT c.id AS id_chauffeur, 
               p.nom AS nom_chauffeur, 
               p.prenom AS prenom_chauffeur,
               YEAR(r.date_arriver) AS annee, 
               COUNT(r.id) AS total_reservations
        FROM reservation r
        JOIN chauffeur c ON r.chauffeur_id = c.id
        JOIN personne p ON c.id_personne_id = p.id
        WHERE YEAR(r.date_arriver) = :annee  
        GROUP BY c.id, p.nom, annee
        ORDER BY total_reservations DESC
        LIMIT 1
        ";

        $conn = $this->getEntityManager()->getConnection();
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':annee', $annee, \Doctrine\DBAL\Types\Types::INTEGER);
        $resultSet = $stmt->executeQuery();

        return $resultSet->fetchAllAssociative();
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
