<?php 

abstract class Utilisateur {

    private $nom;
    private $prenom;
    private $role;
    private $telephone;
    private $email;
    private $mot_de_passe;
    private $photo;
    protected $conn;


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

                    if($gtrole === 'Etudiant' && $gtetat !== 'Refuse'){
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
                        echo '<div id="alert" class="fixed mx-[38rem] mt-[2rem] p-4 mb-4 text-sm text-yellow-800 rounded-lg bg-yellow-50 dark:bg-gray-800 dark:text-yellow-300" role="alert">
                        <span class="font-medium">Demande en traitement!</span> Attendez la confirmation de votre compte Enseignant.
                        </div>';
                    }
                } else {
                    echo '<div id="alert" class="fixed mx-[38rem] mt-[2rem] p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                    <span class="font-medium">Mot de passe incorrect!</span> Essayez un autre mot de passe.
                    </div>';
                }
            } else {
                echo '<div id="alert" class="fixed mx-[38rem] mt-[2rem] p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                    <span class="font-medium">Email non trouvé!</span> Essayez un autre email.
                    </div>';
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

    public function consulterAllCours($page = 1, $coursPerPage = 4) {
        try {
            $offset = ($page - 1) * $coursPerPage;
    
            $stmt = $this->conn->getConnection()->prepare(
                "SELECT cours.*, categories.Nom AS categorie_nom, utilisateurs.Nom AS nom_utilisateur, utilisateurs.Prenom AS prenom_utilisateur, utilisateurs.Photo AS photo_utilisateur 
                FROM cours
                JOIN categories ON cours.Categorie_id = categories.ID
                JOIN utilisateurs ON cours.Enseignant_id = utilisateurs.ID
                WHERE cours.Statut = 'Accepté'
                LIMIT :offset, :coursPerPage"
            );
    
            $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
            $stmt->bindValue(':coursPerPage', $coursPerPage, PDO::PARAM_INT);
    
            $stmt->execute();
    
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
    
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return [];
        }
    }



}