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
    
}


