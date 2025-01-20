<?php

require '../classes/Database.php';
require '../Classes/Cours.php';
require '../Classes/Administrateur.php';
require '../Classes/Commentaire.php';

session_start();

if(!isset($_SESSION['ID'])){
    header('location: ../templates/login.php');
    exit();
}
$ID = $_SESSION['ID'];

$courseId = intval($_GET['id']);

$cours = new Cours("", "", "", "", "", "", "");
$admin = new Administrateur("","","","","","","");
$comment = new Commentaire($ID, $courseId, '');

$course = $cours->getCours($courseId);
$profile = $admin->profileInfos($ID);


if ($profile) {
    $nom = $profile['Nom'];
    $prenom = $profile['Prenom'];
    $photo = $profile['Photo'];
    $role = $profile['Role'];
    $telephone = $profile['Telephone'];
    $email = $profile['Email'];
}

$commentss = $comment->getCommentsByCours($courseId);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Lien du Tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Lien des Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css" integrity="sha512-5Hs3dF2AEPkpNAR7UiOHba+lRSJNeM2ECkwxUIxC1Q/FLycGTbNapWXB4tP889k5T5Ju8fs4b1P5z/iB4nMfSQ==" crossorigin="anonymous" referrerpolicy="no-referrer" /> 
    
    <title>Les Cours</title>
</head>
<body class="bg-gradient-to-t from-green-300 via-green-200 to-green-100 pt-[2rem]">

        
        <main class="bg-white">
        <!-- Cours Details-->
        <div >
            <div class="container mx-auto px-4 py-8">
            <div class="flex flex-wrap -mx-4">
                <div class="w-full md:w-1/2 px-4 mb-8">
                    <iframe width="725" height="450"
                    src="<?php echo htmlspecialchars($course['Contenu']) ?>">
                    </iframe>
                </div>

                <div class="w-full md:w-1/2 px-4">
                <h1 class="text-5xl font-bold leading-tight my-6 text-gray-800 dark:text-gray-100 underline underline-offset-3 decoration-6 decoration-green-200"><?php echo htmlspecialchars($course['Titre']) ?></h1>

                <span class="bg-green-100 text-green-800 text-sm font-semibold me-2 px-3.5 py-1.5 rounded dark:bg-green-900 dark:text-green-300"><?php echo htmlspecialchars($course['Date_creation']) ?></span>
                <p class="text-gray-500 text-lg dark:text-gray-400 my-8"><?php echo htmlspecialchars($course['Description']) ?></p>
                <span class="bg-gray-100 text-gray-800 text-base font-medium me-2 px-3.5 py-1.5 rounded dark:bg-gray-700 dark:text-gray-300"><?php echo htmlspecialchars($course['Type']) ?></span>

                </div>
                
            </div>
            
            </div>
        </div>
        
        <hr class="h-[0.1rem] w-[20rem]] mx-10 bg-green-200 border-0 dark:bg-gray-700">
        <section class="py-24 relative">
        
        <div class="w-full max-w-7xl px-4 md:px-5 lg:px-5 mx-auto">
            
            <div class="w-full flex-col justify-start items-start lg:gap-14 gap-7 inline-flex">
                <h2 class="w-full text-gray-900 text-4xl font-bold font-manrope leading-normal">Comments</h2>

                <?php foreach($commentss as $comments) { ?>
                <div class="w-75 flex-col justify-start items-start gap-8 flex">
                    <div class="w-full pb-6 border-b border-white justify-start items-start gap-2.5 inline-flex">
                        <img class="w-10 h-10 rounded-full object-cover" src="../assets/images/<?php echo $comments['etudiant_photo'] ?>" alt="Photo de Profile" />
                        <div class="w-full flex-col justify-start items-start gap-3.5 inline-flex">
                            <div class="w-full justify-start items-start flex-col flex gap-1">
                                <div class="w-full justify-between items-start gap-1 inline-flex">
                                    <h5 class="text-gray-900 text-sm font-semibold leading-snug mr-[60rem]"><?php echo htmlspecialchars($comments['etudiant_nom']) . ' ' . htmlspecialchars($comments['etudiant_prenom']) ?></h5>
                                    <span class="text-right text-gray-700 text-xs font-normal leading-5"><?php echo htmlspecialchars($comments['commentaire_date']) ?></span>
                                </div>
                                <h5 class="text-gray-800 text-sm font-normal leading-snug"><?php echo htmlspecialchars($comments['commentaire_description']) ?></h5>
                            </div>
                            
                        </div>
                    </div>
                   
                </div>
                <?php } ?>
            </div>
        </div>
    </section>
                                            

    </main>

</body>
</html>