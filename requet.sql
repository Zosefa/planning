SELECT ch.id, p.nom, p.prenom, 
       GROUP_CONCAT(t.numero ORDER BY t.numero SEPARATOR ', ') AS numero, 
       ch.adresse 
FROM Chauffeur ch
LEFT JOIN Personne p ON p.id = ch.id_personne_id
LEFT JOIN Telephone t ON t.id_personne_id = p.id
GROUP BY ch.id, p.nom, p.prenom, ch.adresse;


SELECT
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
    AND YEAR(r.date_arriver) = 2025
GROUP BY m.mois, m.mois_nom
ORDER BY m.mois;


WITH mois AS (
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
         LEFT JOIN itineraire i ON MONTH(i.date_debut) = m.mois_num AND YEAR(i.date_debut) = 2025
    LEFT JOIN depanage d ON MONTH(d.date_depanage) = m.mois_num AND YEAR(d.date_depanage) = 2025
GROUP BY m.mois_num, m.mois_nom
ORDER BY m.mois_num;


