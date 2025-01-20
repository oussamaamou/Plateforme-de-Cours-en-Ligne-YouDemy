<?php

require 'Utilisateur.php';

class Administrateur extends Utilisateur {

    public function accepterEnseignant($ID_enseignant){
        $sql = ("UPDATE utilisateurs SET Etat = 'Valide' WHERE ID = :ID_enseignant");
        $stmt = $this->conn->getConnection()->prepare($sql);

        $stmt->bindParam(':ID_enseignant', $ID_enseignant, PDO::PARAM_INT);

        return $stmt->execute();
        
    }

    public function refuserEnseignant($ID_enseignant){
        $sql = ("UPDATE utilisateurs SET Etat = 'Refuse' WHERE ID = :ID_enseignant");
        $stmt = $this->conn->getConnection()->prepare($sql);

        $stmt->bindParam(':ID_enseignant', $ID_enseignant, PDO::PARAM_INT);

        return $stmt->execute();
        
    }

    public function getTotalEtudiant() {
        $sql = "SELECT count(Nom) FROM utilisateurs WHERE Role = 'Etudiant'";
        $stmt = $this->conn->getConnection()->prepare($sql);
        $stmt->execute();
        return $stmt->fetchColumn();
    }

    public function getTotalEnseignant() {
        $sql = "SELECT count(Nom) FROM utilisateurs WHERE Role = 'Enseignant' AND Etat = 'Valide' ";
        $stmt = $this->conn->getConnection()->prepare($sql);
        $stmt->execute();
        return $stmt->fetchColumn();
    }

    public function getTotalCours() {
        $sql = "SELECT count(Titre) FROM cours WHERE Statut = 'Accepté' ";
        $stmt = $this->conn->getConnection()->prepare($sql);
        $stmt->execute();
        return $stmt->fetchColumn();
    }

    public function getTotalUtilisateur() {
        $sql = "SELECT count(Nom) FROM utilisateurs WHERE Etat = 'Valide' ";
        $stmt = $this->conn->getConnection()->prepare($sql);
        $stmt->execute();
        return $stmt->fetchColumn();
    }

    public function consulterAllCours($page = 1, $coursPerPage = 4) {
        try {
            $offset = ($page - 1) * $coursPerPage;
    
            $stmt = $this->conn->getConnection()->prepare(
                "SELECT cours.*, categories.Nom AS categorie_nom, utilisateurs.Nom AS nom_utilisateur, utilisateurs.Prenom AS prenom_utilisateur, utilisateurs.Photo AS photo_utilisateur 
                FROM cours
                JOIN categories ON cours.Categorie_id = categories.ID
                JOIN utilisateurs ON cours.Enseignant_id = utilisateurs.ID
                WHERE cours.Statut = 'Encours'
                LIMIT :offset, :coursPerPage"
            );
    
            $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
            $stmt->bindValue(':coursPerPage', $coursPerPage, PDO::PARAM_INT);
    
            $stmt->execute();
    
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
    
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return [];
        }
    }
    
}


