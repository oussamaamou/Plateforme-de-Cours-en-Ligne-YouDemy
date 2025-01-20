<?php

require '../classes/Database.php';
require '../Classes/Cours.php';
require '../Classes/Etudiant.php';
require '../Classes/Commentaire.php';

session_start();

if(!isset($_SESSION['ID'])){
    header('location: ../templates/login.php');
    exit();
}
$ID_Etudiant = $_SESSION['ID'];

$courseId = intval($_GET['id']);

$cours = new Cours("", "", "", "", "", "", "");
$etudiant = new Etudiant('','','','','','','');
$comment = new Commentaire($ID_Etudiant, $courseId, '');

$course = $cours->getCours($courseId);
$profile = $etudiant->profileInfos($ID_Etudiant);


if ($profile) {
    $nom = $profile['Nom'];
    $prenom = $profile['Prenom'];
    $photo = $profile['Photo'];
    $role = $profile['Role'];
    $telephone = $profile['Telephone'];
    $email = $profile['Email'];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cours_inscription'])) {
    $ID_cours = $_POST['ID_cours'] ?? null;
    if ($ID_cours) {
        $etudiant->coursInscription($ID_Etudiant, $ID_cours);
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_comment'])) {
   
    $comment->setDescription($description = $_POST['description']);

    $comment->addComment($ID_Etudiant, $courseId, $description);

}

$commentss = $comment->getCommentsByCours();
$inscrit = $etudiant->inscriptionCours($ID_Etudiant, $courseId);

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
<body class="bg-gradient-to-t from-green-300 via-green-200 to-green-100">

    <header class="mb-[4rem]">
        <nav class="bg-white border-gray-200 px-4 lg:px-6 py-2.5 dark:bg-gray-800">
            <div class="flex flex-wrap justify-between items-center mx-auto max-w-screen-xl">
                <a class="flex items-center">
                    <img src="../assets/images/YouDemy_Logo.png" class="mr-3 mt-[-1rem] w-[7rem]" alt="Site Web Logo" />
                </a>
                <div class="flex items-center lg:order-2 mt-[-1rem]">
                    <a href="../templates/logout.php" class="text-white bg-green-500 hover:opacity-80 font-medium rounded-lg text-sm px-4 lg:px-5 py-2 lg:py-2.5 mr-2 dark:bg-primary-600 dark:hover:bg-primary-700 focus:outline-none dark:focus:ring-primary-800">Logout</a>
                    <button data-collapse-toggle="mobile-menu-2" type="button" class="inline-flex items-center p-2 ml-1 text-sm text-gray-500 rounded-lg lg:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600" aria-controls="mobile-menu-2" aria-expanded="false">
                        <span class="sr-only">Open main menu</span>
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"></path></svg>
                        <svg class="hidden w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                    </button>
                </div>
                <div class="hidden justify-between items-center w-full lg:flex lg:w-auto lg:order-1 mt-[-1rem]" id="mobile-menu-2">
                    <ul class="flex flex-col mt-4 font-medium lg:flex-row lg:space-x-8 lg:mt-0">
                        <li>
                            <a href="cours_etudiant.php" class="block py-2 pr-4 pl-3 text-stone-700 rounded bg-primary-700 lg:bg-transparent lg:text-primary-700 lg:p-0 dark:text-white" aria-current="page">Home</a>
                        </li>
                        <li>
                            <a href="profile_etudiant.php" class="block py-2 pr-4 pl-3 text-stone-700 border-b border-gray-100 hover:bg-gray-50 lg:hover:bg-transparent lg:border-0 lg:hover:text-primary-700 lg:p-0 dark:text-gray-400 lg:dark:hover:text-white dark:hover:bg-gray-700 dark:hover:text-white lg:dark:hover:bg-transparent dark:border-gray-700">Profile</a>
                        </li>
                        <li>
                            <a href="mes_cours.php" class="block py-2 pr-4 pl-3 text-stone-700 border-b border-gray-100 hover:bg-gray-50 lg:hover:bg-transparent lg:border-0 lg:hover:text-primary-700 lg:p-0 dark:text-gray-400 lg:dark:hover:text-white dark:hover:bg-gray-700 dark:hover:text-white lg:dark:hover:bg-transparent dark:border-gray-700">Mes Cours</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <!-- Inscription -->
    <form id="coursInscription" method="POST" action="">
            <input type="hidden" name="cours_inscription" value="1">
            <input type="hidden" name="ID_cours" id="ID_cours" value="">
        </form>

    <main class="overflow-hidden bg-white">

        
        
        <!-- Cours Details-->
        <div >
            <div class="container mx-auto px-4 py-8">
            <div class="flex flex-wrap -mx-4">
                <div class="w-full md:w-1/2 px-4 mb-8">
                    <?php if (!$inscrit): ?>
                    <div class="p-4 mt-[8rem] text-red-800 border border-red-300 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400 dark:border-red-800" role="alert">
                        <div class="pl-[15rem] flex items-center">
                            <svg class="flex-shrink-0 w-4 h-4 me-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                            </svg>
                            <span class="sr-only">Info</span>
                            <h3 class="text-lg font-medium">Alerte Informative</h3>
                        </div>
                        <div class="mt-2 mb-4 pl-[2rem] text-sm">
                            Vous devez vous inscrire au cours pour pouvoir accéder au contenu et interagir avec celui-ci.
                        </div>
                    </div>
                    <?php endif; ?>

                    <?php if ($inscrit): ?>
                    <iframe width="725" height="450"
                    src="<?php echo htmlspecialchars($course['Contenu']) ?>">
                    </iframe>
                    <?php endif; ?>
                </div>

                <div class="w-full md:w-1/2 px-4">
                <?php if (!$inscrit): ?>
                <button onclick="coursInscription(<?php echo $course['ID'] ?>)" type='button' class='ml-[32rem] py-2.5 px-6 text-sm rounded-lg bg-red-500 text-white cursor-pointer font-semibold text-center shadow-xs transition-all duration-500 hover:bg-red-700'>S'Inscrire</button>
                <?php endif; ?>
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
                <?php if ($inscrit): ?>
                <form method="POST" class="w-full flex-col justify-start items-start gap-5 flex">
                    <div class="w-full rounded-3xl justify-start items-start gap-3.5 inline-flex">
                        <img class="w-11 h-11 rounded-full object-cover" src="../assets//images/<?php echo $photo ?>" alt="John smith image" />
                        <input type="hidden" name="add_comment" value="1">
                        <input type="text" name="description" rows="5" class="w-full h-[6rem] px-5 py-3 rounded-2xl border border-gray-300 shadow-[0px_1px_2px_0px_rgba(16,_24,_40,_0.05)] resize-none focus:outline-none placeholder-gray-400 text-gray-900 text-base font-normal leading-7" placeholder="Écrivez vos pensées ici....">
                    </div>
                    <button class="ml-[4rem] px-2.5 py-2.5 bg-green-500 hover:bg-green-600 transition-all duration-700 ease-in-out rounded-full shadow-[0px_1px_2px_0px_rgba(16,_24,_40,_0.05)] justify-center items-center flex">
                        <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 20 20" fill="none">
                            <path d="M11.3011 8.69906L8.17808 11.8221M8.62402 12.5909L8.79264 12.8821C10.3882 15.638 11.1859 17.016 12.2575 16.9068C13.3291 16.7977 13.8326 15.2871 14.8397 12.2661L16.2842 7.93238C17.2041 5.17273 17.6641 3.79291 16.9357 3.06455C16.2073 2.33619 14.8275 2.79613 12.0679 3.71601L7.73416 5.16058C4.71311 6.16759 3.20259 6.6711 3.09342 7.7427C2.98425 8.81431 4.36221 9.61207 7.11813 11.2076L7.40938 11.3762C7.79182 11.5976 7.98303 11.7083 8.13747 11.8628C8.29191 12.0172 8.40261 12.2084 8.62402 12.5909Z"
                                stroke="#ffffff" stroke-width="1.6" stroke-linecap="round" />
                        </svg>
                    </button>
                </form>
                <?php endif; ?>

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





    <script>
        function coursInscription(ID_cours) {
        document.getElementById("ID_cours").value = ID_cours;
        document.getElementById("coursInscription").submit();
        };
    </script>
</body>
</html>