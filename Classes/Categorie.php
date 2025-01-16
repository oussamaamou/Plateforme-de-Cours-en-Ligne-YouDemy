<?php

class Categorie {

    private $conn;
    private $nom;

    public function __construct($conn){
        $this->conn = $conn;
    }

    public function setNom($nom){
        $this->nom = $nom;
    }

    public function getNom(){
        return $this->nom;
    }

    public function creerCategorie(){

        $sql = ("INSERT INTO categories (Nom) VALUES (:nom)");

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':nom', $this->nom, PDO::PARAM_STR);

        return $stmt->execute();
    }

    public function supprimerCategorie($id){

        $stmt = $this->conn->prepare("DELETE FROM categorie WHERE ID = :id");

        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        
    
        return $stmt->execute();
    }

    public function getAllCategorie(){
        try{ 
            $sql = ("SELECT * FROM categories");
            $stmt = $this->conn->prepare($sql);
            
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
       }
       catch(PDOException $e){
        echo "Error: " . $e->getMessage();
        return [];
       }
        
    }



}