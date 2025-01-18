<?php


include_once 'Utilisateur.php';

class Etudiant extends Utilisateur {

    public function rechercherCours($searchTerm){
        $sql = ("SELECT cours.*, categories.Nom AS categorie_nom, utilisateurs.Nom AS nom_utilisateur, utilisateurs.Prenom AS prenom_utilisateur, utilisateurs.Photo AS photo_utilisateur 
                FROM cours
                JOIN categories ON cours.Categorie_id = categories.ID
                JOIN utilisateurs ON cours.Enseignant_id = utilisateurs.ID
                WHERE utilisateurs.Nom LIKE :searchTerm OR utilisateurs.Prenom LIKE :searchTerm OR cours.Titre LIKE :searchTerm AND cours.Statut = 'Accepté'"
        );

        $stmt = $this->conn->getConnection()->prepare($sql);
        $searchTerm = "%$searchTerm%";
        $stmt->bindParam(':searchTerm', $searchTerm);

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
}