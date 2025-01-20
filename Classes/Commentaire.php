<?php

require_once 'Database.php';

class Commentaire{
    
    private $ID_etudiant;
    private $ID_cours;
    private $description;
    private $conn;

    public function __construct($ID_etudiant, $ID_cours, $description){
        $this->ID_etudiant = $ID_etudiant;
        $this->ID_cours = $ID_cours;
        $this->description = $description;
        $this->conn = new Database;

    }

    public function setEtudiant($ID_etudiant) {
        $this->ID_etudiant = $ID_etudiant;
        
    }

    public function setCours($ID_cours) {
        $this->ID_cours = $ID_cours;
        
    }

    public function setDescription($description) {
        $this->description = $description;
        
    }

    public function getEtudiant() {
        return $this->ID_etudiant;
    }

    public function getCours() {
        return $this->ID_cours;
    }

    public function getDescription() {
        return $this->description;
    }

    public function addComment(){
        $sql = ("INSERT INTO commentaires (ID_etudiant, ID_cours, Description) VALUES(:ID_etudiant, :ID_cours, :description)");
        $stmt = $this->conn->getConnection()->prepare($sql);

        $stmt->bindParam(':ID_etudiant', $this->ID_etudiant, PDO::PARAM_INT);
        $stmt->bindParam(':ID_cours', $this->ID_cours, PDO::PARAM_INT);
        $stmt->bindParam(':description', $this->description, PDO::PARAM_STR);

        return $stmt->execute();
    }

    public function getCommentsByCours(){
        try{
            $sql = "SELECT c.ID, c.Description AS commentaire_description, c.Date_publication AS commentaire_date, 
                           u.Nom AS etudiant_nom, u.Photo AS etudiant_photo, u.Prenom AS etudiant_prenom, u.Email AS etudiant_email, 
                           a.Titre AS cours_titre
                    FROM commentaires c
                    INNER JOIN utilisateurs u ON c.ID_etudiant = u.ID
                    INNER JOIN cours a ON c.ID_cours = a.ID
                    WHERE c.ID_cours = :ID_cours";  
    
            $stmt = $this->conn->getConnection()->prepare($sql);
            $stmt->bindParam(':ID_cours', $this->ID_cours, PDO::PARAM_INT);
            $stmt->execute();
    
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        catch(PDOException $e){
            echo "Erreur : " . $e->getMessage();
            return [];
        }
    }
}