<?php

class Tags {

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

    public function creerTag(){

        $sql = ("INSERT INTO tags (Nom) VALUES (:nom)");

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':nom', $this->nom, PDO::PARAM_STR);

        return $stmt->execute();
    }

    public function supprimerTag($id){

        $stmt = $this->conn->prepare("DELETE FROM tags WHERE ID = :id");

        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        
    
        return $stmt->execute();
    }


}