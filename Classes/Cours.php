<?php

class Cours {

    private $ID_enseignant;
    private $ID_categorie;
    private $titre;
    private $contenu;
    private $thumbnail;
    private $description;
    private $type;
    private $conn;

    public function __construct($ID_enseignant, $ID_categorie, $titre, $contenu, $thumbnail, $description, $type) {
        $this->ID_enseignant = $ID_enseignant;
        $this->ID_categorie = $ID_categorie;
        $this->titre = $titre;
        $this->contenu = $contenu;
        $this->thumbnail = $thumbnail;
        $this->description = $description;
        $this->type = $type;
        $this->conn = new Database();
    }

    public function setEnseignant($ID_enseignant) {
        $this->ID_enseignant = $ID_enseignant;
    }

    public function setCategorie($ID_categorie) {
        $this->ID_categorie = $ID_categorie;
    }

    public function setTitre($titre) {
        $this->titre = $titre;
    }

    public function setDescription($description) {
        $this->description = $description;
    }

    public function setContenu($contenu) {
        $this->contenu = $contenu;
    }

    public function setThumbnail($thumbnail) {
        $this->thumbnail = $thumbnail;
    }

    public function setType($type) {
        $this->type = $type;
    }

    public function getEnseignant() {
        return $this->ID_enseignant;
    }

    public function getCategorie() {
        return $this->ID_categorie;
    }

    public function getTitre() {
        return $this->titre;
    }

    public function getDescription() {
        return $this->description;
    }

    public function getContenu() {
        return $this->contenu;
    }

    public function getThumbnail() {
        return $this->thumbnail;
    }

    public function getType() {
        return $this->type;
    }

    public function creerCours() {
        $sql = "INSERT INTO cours (Titre, Description, Type, Contenu, Thumbnail, Enseignant_id, Categorie_id)
                VALUES (:titre, :description, :type, :contenu, :thumbnail, :Enseignant_id, :Categorie_id)";
        
        $stmt = $this->conn->getConnection()->prepare($sql);

        $stmt->bindParam(':Enseignant_id', $this->ID_enseignant, PDO::PARAM_INT);
        $stmt->bindParam(':Categorie_id', $this->ID_categorie, PDO::PARAM_INT);
        $stmt->bindParam(':titre', $this->titre, PDO::PARAM_STR);
        $stmt->bindParam(':description', $this->description, PDO::PARAM_STR);
        $stmt->bindParam(':contenu', $this->contenu, PDO::PARAM_STR);
        $stmt->bindParam(':type', $this->type, PDO::PARAM_STR);
        $stmt->bindParam(':thumbnail', $this->thumbnail, PDO::PARAM_LOB);

        return $stmt->execute();
    }

    public function getAllCours() {
        try {
            $stmt = $this->conn->getConnection()->prepare(
                "SELECT cours.*, categories.Nom AS categorie_nom, utilisateurs.Nom AS nom_utilisateur, utilisateurs.Prenom AS prenom_utilisateur, utilisateurs.Photo AS photo_utilisateur 
                FROM cours
                JOIN categories ON cours.Categorie_id = categories.ID
                JOIN utilisateurs ON cours.Enseignant_id = utilisateurs.ID
                Limit 4"
            );
            
    
            $stmt->execute();
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
    
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return [];
        }
    }

    public function getCours($id){
        try {
            $stmt = $this->conn->getConnection()->prepare("SELECT * FROM cours WHERE ID = :id");
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);

            $stmt->execute();

            $course = $stmt->fetch(PDO::FETCH_ASSOC);
            return $course;
        }catch (PDOException $e) {
            echo "Error fetching course: " . $e->getMessage();
            return false;
        }
    }





}