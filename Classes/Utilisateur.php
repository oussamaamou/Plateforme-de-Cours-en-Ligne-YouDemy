<?php 

abstract class Utilisateur {

    private $nom;
    private $prenom;
    private $role;
    private $telephone;
    private $email;
    private $mot_de_passe;
    private $photo;
    private $conn;


    public function __construct($nom, $prenom, $role, $telephone, $email, $mot_de_passe, $photo) {
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->role = $role;
        $this->telephone = $telephone;
        $this->email = $email;
        $this->mot_de_passe = $mot_de_passe;
        $this->photo = $photo;
        $this->conn = new Database();
    }

    public function setNom($nom) {
        $this->nom = $nom;
    }

    public function setPrenom($prenom) {
        $this->prenom = $prenom;
    }

    public function setRole($role) {
        $this->role = $role;
    }

    public function setTelephone($telephone) {
        $this->telephone = $telephone;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function setMotDePasse($mot_de_passe) {
        $this->mot_de_passe = password_hash($mot_de_passe, PASSWORD_DEFAULT);
    }

    public function setPhoto($photo) {
        $this->photo = $photo;
    }

    public function getNom() {
        return $this->nom;
    }

    public function getPrenom() {
        return $this->prenom;
    }

    public function getRole() {
        return $this->role;
    }

    public function getTelephone() {
        return $this->telephone;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getMotDePasse() {
        return $this->mot_de_passe;
    }

    public function getPhoto() {
        return $this->photo;
    }


    public function inscriptionUtilisateur() {

        $sql = "INSERT INTO utilisateurs (Nom, Prenom, Photo, Telephone, Email, Mot_de_passe, Role) 
                VALUES (:nom, :prenom, :photo, :telephone, :email, :mot_de_passe, :role)";
        $stmt = $this->conn->getConnection()->prepare($sql);

        $stmt->bindParam(':nom', $this->nom, PDO::PARAM_STR);
        $stmt->bindParam(':prenom', $this->prenom, PDO::PARAM_STR);
        $stmt->bindParam(':photo', $this->photo, PDO::PARAM_LOB);
        $stmt->bindParam(':telephone', $this->telephone, PDO::PARAM_STR);
        $stmt->bindParam(':email', $this->email, PDO::PARAM_STR);
        $stmt->bindParam(':mot_de_passe', $this->mot_de_passe, PDO::PARAM_STR);
        $stmt->bindParam(':role', $this->role, PDO::PARAM_STR);

        return $stmt->execute();
    }


    public function loginUtilisateur($email, $mot_de_passe) {
        $sql = "SELECT * FROM utilisateurs WHERE Email = :email"; 
        $stmt = $this->conn->getConnection()->prepare($sql);
    
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    
        if($stmt->execute()) {
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
            if ($result) {
                $gtID = $result['ID'];
                $gtrole = $result['Role'];
                $gtemail = $result['Email'];
                $gtetat = $result['Etat'];
                $gtmot_de_passe = $result['Mot_de_passe'];

                if($this->email === $gtemail && password_verify($mot_de_passe, $gtmot_de_passe)) {
                    $_SESSION['ID'] = $gtID;

                    if($gtrole === 'Etudiant'){
                        header("Location: ../views/profile_etudiant.php");
                        exit();
                    }
                    if($gtrole === 'Enseignant' && $gtetat === 'Valide'){
                        header("Location: ../views/profile_enseignant.php");
                        exit();
                    }
                    if($gtrole === 'Administrateur'){
                        header("Location: ../views/profile_administrateur.php");
                        exit();
                    }
                    else{
                        header("Location: ../templates/login.php");
                        exit();
                    }
                } else {
                    echo "Mot de passe incorrect";
                }
            } else {
                echo "Email non trouvé.";
            }
        } else {
            echo "Erreur lors de l'exécution de la requête.";
        }
    }

    public function profileInfos($id) {
        try {
            $sql = "SELECT Nom, Prenom, Photo, Role, Telephone, Email FROM utilisateurs WHERE ID = :id";
            $stmt = $this->conn->getConnection()->prepare($sql);

            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();

            if($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                return [
                    'Nom' => $row['Nom'],
                    'Prenom' => $row['Prenom'],
                    'Photo' => $row['Photo'],
                    'Role' => $row['Role'],
                    'Telephone' => $row['Telephone'],
                    'Email' => $row['Email']
                ];
            } else {
                return null;
            }
        } catch(PDOException $e) {
            echo "Erreur : " . $e->getMessage();
            return null;
        }
    }



}