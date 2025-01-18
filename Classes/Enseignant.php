<?php

include_once 'Utilisateur.php';

class Enseignant extends Utilisateur {

    public function getRefusedEnseignants() {
        $sql = "SELECT * FROM utilisateurs WHERE Role = 'Enseignant' AND Etat = 'refuse'";

        $stmt = $this->conn->getConnection()->prepare($sql);
        
        $stmt->execute();

        $enseignants = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $enseignants;
    }
    
}