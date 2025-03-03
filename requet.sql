SELECT ch.id, p.nom, p.prenom, 
       GROUP_CONCAT(t.numero ORDER BY t.numero SEPARATOR ', ') AS numero, 
       ch.adresse 
FROM Chauffeur ch
LEFT JOIN Personne p ON p.id = ch.id_personne_id
LEFT JOIN Telephone t ON t.id_personne_id = p.id
GROUP BY ch.id, p.nom, p.prenom, ch.adresse;
