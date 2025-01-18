<?php

class Categorie {

    private $conn;
    private $nom;

    public function __construct($nom){
        $this->nom = $nom;
        $this->conn = new Database();
    }

    public function setNom($nom){
        $this->nom = $nom;
    }

    public function getNom(){
        return $this->nom;
    }

    public function creerCategorie(){

        $sql = ("INSERT INTO categories (Nom) VALUES (:nom)");

        $stmt = $this->conn->getConnection()->prepare($sql);
        $stmt->bindParam(':nom', $this->nom, PDO::PARAM_STR);

        return $stmt->execute();
    }

    public function supprimerCategorie($id){

        $stmt = $this->conn->getConnection()->prepare("DELETE FROM categorie WHERE ID = :id");

        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        
    
        return $stmt->execute();
    }

    public function getAllCategorie(){
        try{ 
            $sql = ("SELECT * FROM categories");
            $stmt = $this->conn->getConnection()->prepare($sql);
            
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
       }
       catch(PDOException $e){
        echo "Error: " . $e->getMessage();
        return [];
       }
        
    }

    public function filtrerCours($coursFilter){
        $sql = ("SELECT cours.*, categories.Nom AS categorie_nom, utilisateurs.Nom AS nom_utilisateur, utilisateurs.Prenom AS prenom_utilisateur, utilisateurs.Photo AS photo_utilisateur 
                FROM cours
                JOIN categories ON cours.Categorie_id = categories.ID
                JOIN utilisateurs ON cours.Enseignant_id = utilisateurs.ID
                WHERE categories.ID = :coursFilter AND cours.Statut = 'Accepté'"
        );

        $stmt = $this->conn->getConnection()->prepare($sql);
        $stmt->bindParam(':coursFilter', $coursFilter);

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }



}