<?php

include_once 'Utilisateur.php';

class Enseignant extends Utilisateur {

    public function getDemandeEnseignants() {
        $sql = "SELECT * FROM utilisateurs WHERE Role = 'Enseignant' AND Etat = 'En Attente'";

        $stmt = $this->conn->getConnection()->prepare($sql);
        
        $stmt->execute();

        $enseignants = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $enseignants;
    }

    public function getAllEnseignants() {
        $sql = "SELECT * FROM utilisateurs WHERE Role = 'Enseignant' AND Etat = 'Valide'";

        $stmt = $this->conn->getConnection()->prepare($sql);
        
        $stmt->execute();

        $enseignants = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $enseignants;
    }

    public function consulterAllCours($page = 1, $coursPerPage = 4, $enseignant_id = null) {
        try {
            $offset = ($page - 1) * $coursPerPage;

            $sql = "SELECT cours.*, categories.Nom AS categorie_nom
                    FROM cours
                    JOIN categories ON cours.Categorie_id = categories.ID
                    WHERE cours.Enseignant_id = :enseignant_id AND cours.Statut = 'Accepté'
                    LIMIT :offset, :coursPerPage";

            $stmt = $this->conn->getConnection()->prepare($sql);

            $stmt->bindParam(':enseignant_id', $enseignant_id, PDO::PARAM_INT);
            $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
            $stmt->bindParam(':coursPerPage', $coursPerPage, PDO::PARAM_INT);

            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            echo "Erreur : " . $e->getMessage();
            return [];
        }
    }

    public function ttlInscritsCours($id_cours) {
        $sql = "SELECT COUNT(u.ID) 
                FROM utilisateurs u
                JOIN inscriptions i ON u.ID = i.ID_etudiant
                WHERE i.ID_cours = :id_cours AND u.Role = 'Etudiant'";
    
        $stmt = $this->conn->getConnection()->prepare($sql);
        $stmt->bindParam(':id_cours', $id_cours, PDO::PARAM_INT);
        $stmt->execute();
    
        return $stmt->fetchColumn();
    }

    public function ttlInscritsEnseignant($id_enseignant) {
        $sql = "SELECT COUNT(u.ID) 
                FROM utilisateurs u
                JOIN inscriptions i ON u.ID = i.ID_etudiant
                JOIN cours c ON i.ID_cours = c.ID
                WHERE c.Enseignant_id = :id_enseignant AND u.Role = 'Etudiant'";
    
        $stmt = $this->conn->getConnection()->prepare($sql);
        $stmt->bindParam(':id_enseignant', $id_enseignant, PDO::PARAM_INT);
        $stmt->execute();
    
        return $stmt->fetchColumn();
    }

    public function ttlCoursEnseignant($id_enseignant) {
        $sql = "SELECT COUNT(*) 
                FROM cours 
                WHERE Enseignant_id = :id_enseignant AND Statut = 'Accepté'";
    
        $stmt = $this->conn->getConnection()->prepare($sql);
        $stmt->bindParam(':id_enseignant', $id_enseignant, PDO::PARAM_INT);
        $stmt->execute();
    
        return $stmt->fetchColumn();
    }

    public function etudiantsInscritsCours($id_enseignant) {
        $sql = "SELECT DISTINCT u.Photo, u.Nom, u.Prenom, u.Role 
                FROM utilisateurs u
                JOIN inscriptions i ON u.ID = i.ID_etudiant
                JOIN cours c ON i.ID_cours = c.ID
                WHERE c.Enseignant_id = :id_enseignant AND u.Role = 'Etudiant'";
    
        $stmt = $this->conn->getConnection()->prepare($sql);
        $stmt->bindParam(':id_enseignant', $id_enseignant, PDO::PARAM_INT);
        $stmt->execute();
    
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    
    



    
}