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



    
}