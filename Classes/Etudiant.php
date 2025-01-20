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

    public function getAllEtudiants() {
        $sql = "SELECT * FROM utilisateurs WHERE Role = 'Etudiant'";

        $stmt = $this->conn->getConnection()->prepare($sql);
        
        $stmt->execute();

        $enseignants = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $enseignants;
    }

    public function coursInscription($ID_etudiant, $ID_cours){
        $sql = ("INSERT INTO inscriptions (ID_etudiant, ID_cours) VALUES (:ID_etudiant, :ID_cours)");

        $stmt = $this->conn->getConnection()->prepare($sql);

        $stmt->bindParam('ID_etudiant', $ID_etudiant, PDO::PARAM_INT);
        $stmt->bindParam('ID_cours', $ID_cours, PDO::PARAM_INT);

        return $stmt->execute();
    }

    public function inscriptionCours($ID_etudiant, $ID_cours) {
        $sql = "SELECT COUNT(*) FROM inscriptions WHERE ID_etudiant = :ID_etudiant AND ID_cours = :ID_cours";
        
        $stmt = $this->conn->getConnection()->prepare($sql);
        
        $stmt->bindParam(':ID_etudiant', $ID_etudiant, PDO::PARAM_INT);
        $stmt->bindParam(':ID_cours', $ID_cours, PDO::PARAM_INT);
        
        $stmt->execute();
        
        return $stmt->fetchColumn() > 0;
    }
    
}