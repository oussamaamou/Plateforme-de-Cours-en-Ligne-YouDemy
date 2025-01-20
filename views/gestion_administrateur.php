<?php

require '../Classes/Database.php';
require '../Classes/Categorie.php';
require '../Classes/Tags.php';
require '../Classes/Administrateur.php';

session_start();

if(!isset($_SESSION['ID'])){
    header('location: ../templates/login.php');
    exit();
}

$ID = $_SESSION['ID']; 

$categorie = new Categorie('');
$tag = new Tags('');
$infos = new Administrateur('','','','','','','');

$profile = $infos->profileInfos($ID);
$categoriess = $categorie->getAllCategorie();
$tagss = $tag->getAllTags();

if ($profile) {
    $prnom = $profile['Nom'];
    $prenom = $profile['Prenom'];
    $photo = $profile['Photo'];
    $role = $profile['Role'];
    $telephone = $profile['Telephone'];
    $email = $profile['Email'];
}

if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_categorie'])){
    
    $categorie->setNom($nom = $_POST['nom']);
    $categorie->creerCategorie();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_categorie'])) {
    $ID_categorie = $_POST['categorie_ID_Supp'] ?? null;
    if ($ID_categorie) {
        $categorie->supprimerCategorie($ID_categorie);
    }
}

if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_tag'])){
    $tag->setNom($nom = $_POST['nom']);

    $tag->creerTag();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_tags'])) {
    $ID_tag = $_POST['tags_ID_Supp'] ?? null;
    if ($ID_tag) {
        $tag->supprimerTag($ID_tag);
    }
}

$ttlEtudiant = $infos->getTotalEtudiant();
$ttlEnseignant = $infos->getTotalEnseignant();
$ttlCours = $infos->getTotalCours();
$ttlUsers = $infos->getTotalUtilisateur();

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
    
    <title>Gestion</title>
</head>
<body class="flex bg-gray-100 min-h-screen">
    <aside class="hidden sm:flex sm:flex-col">
        <a class="inline-flex items-center justify-center h-20 w-20 hover:bg-green-500 focus:bg-green-500">
            <img src="../assets/images/YouDemy_Logo.png" alt="Site Web Logo" />
        </a>
        <div class="flex-grow flex flex-col justify-between text-gray-500 bg-gray-800">
        <nav class="flex flex-col mx-4 my-6 space-y-4">
            
            <a href="gestion_administrateur.php" class="inline-flex items-center justify-center py-3 text-green-600 bg-white rounded-lg">
            <span class="sr-only">Dashboard</span>
            <svg aria-hidden="true" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="h-6 w-6">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
            </svg>
            </a>

            <a href="gestion_demande.php" class="inline-flex items-center justify-center py-3 hover:text-gray-400 hover:bg-gray-700 focus:text-gray-400 focus:bg-gray-700 rounded-lg">
            <span class="sr-only">Messages</span>
            <svg aria-hidden="true" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="h-6 w-6">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
            </svg>
            </a>

            <a href="gestion_utilisateur.php" class="inline-flex items-center justify-center py-3 hover:text-gray-400 hover:bg-gray-700 focus:text-gray-400 focus:bg-gray-700 rounded-lg">
            <span class="sr-only">Utilisateur</span>
            <svg class="w-6 h-6 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 18 20">
                <path d="M16 0H4a2 2 0 0 0-2 2v1H1a1 1 0 0 0 0 2h1v2H1a1 1 0 0 0 0 2h1v2H1a1 1 0 0 0 0 2h1v2H1a1 1 0 0 0 0 2h1v1a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2Zm-5.5 4.5a3 3 0 1 1 0 6 3 3 0 0 1 0-6ZM13.929 17H7.071a.5.5 0 0 1-.5-.5 3.935 3.935 0 1 1 7.858 0 .5.5 0 0 1-.5.5Z"/>
            </svg>
            </a>

            <a href="gestion_cours.php" class="inline-flex items-center justify-center py-3 hover:text-gray-400 hover:bg-gray-700 focus:text-gray-400 focus:bg-gray-700 rounded-lg">
            <span class="sr-only">Tous les Cours</span>
            <svg class="w-6 h-6 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 18 20">
                <path d="M15 1.943v12.114a1 1 0 0 1-1.581.814L8 11V5l5.419-3.871A1 1 0 0 1 15 1.943ZM7 4H2a2 2 0 0 0-2 2v4a2 2 0 0 0 2 2v5a2 2 0 0 0 2 2h1a2 2 0 0 0 2-2V4ZM4 17v-5h1v5H4ZM16 5.183v5.634a2.984 2.984 0 0 0 0-5.634Z"/>
            </svg>
            </a>

            <a href="profile_administrateur.php" class="inline-flex items-center justify-center py-3 hover:text-gray-400 hover:bg-gray-700 focus:text-gray-400 focus:bg-gray-700 rounded-lg">
            <svg aria-hidden="true" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="h-6 w-6">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
            </svg>
            </a>
            
        </nav>
        </div>
    </aside>
    <div class="flex-grow text-gray-800">
        <header class="flex items-center h-20 px-6 sm:px-10 bg-white">
            <div class="flex flex-shrink-0 items-center ml-auto">
                <div class="hidden md:flex md:flex-col md:items-end md:leading-tight">
                    <span class="font-semibold"><?php echo $prnom . ' ' . $prenom; ?></span>
                    <span class="text-sm text-gray-600"><?php echo $role; ?></span>
                </div>
                <span class="h-12 w-12 ml-2 sm:ml-3 mr-2 bg-gray-100 rounded-full overflow-hidden">
                    <img src="../assets/images/<?php echo $photo; ?>" alt="user profile photo" class="h-full w-full object-cover">
                </span>
            
                <div class="border-l pl-3 ml-3 space-x-1">
                    <button class="relative p-2 text-gray-400 hover:bg-gray-100 hover:text-gray-600 focus:bg-gray-100 focus:text-gray-600 rounded-full">
                    <a href="../templates/logout.php">
                        <span class="sr-only">Log out</span>
                        <svg aria-hidden="true" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="h-6 w-6">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                    </a>
                    </button>
                </div>
            </div>
        </header>
        
        <main class="p-6 sm:p-10 space-y-6">

            <!-- Form Suppression-->
            <form id="supprimerCategorie" method="POST" action="">
                <input type="hidden" name="delete_categorie" value="1">
                <input type="hidden" name="categorie_ID_Supp" id="categorie_ID_Supp" value="">
            </form>

            <!-- Form Suppression-->
            <form id="supprimerTags" method="POST" action="">
                <input type="hidden" name="delete_tags" value="1">
                <input type="hidden" name="tags_ID_Supp" id="tags_ID_Supp" value="">
            </form>
            
            <div id="ctnrcsltion" class="hidden fixed left-[32rem] top-[-1rem] flex flex-col items-center justify-center px-6 py-8 mx-auto md:h-screen lg:py-0">
                <div class="w-full bg-white rounded-lg shadow dark:border md:mt-0 sm:max-w-md xl:pr-4 xl:p-0 dark:bg-gray-800 dark:border-gray-700">
                    <i id="xmarkcsltion" class="fa-solid fa-xmark ml-[26rem] text-2xl cursor-pointer mt-[1.2rem]" style="color: #2e2e2e;"></i>
                    <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
                        <h1 class="text-xl font-bold leading-tight tracking-tight text-stone-700 md:text-2xl dark:text-white">
                            Créer Catégorie
                        </h1>
                        <form class="space-y-4 md:space-y-6" method="POST">
                            <input type="hidden" name="add_categorie" value="1">
                            <input type="hidden" name="avocat_ID" id="avocat_ID" value="">
                                <div>
                                    <label for="nom" class="block mb-2 text-sm font-medium text-stone-700 dark:text-white">Nom</label>
                                    <input type="text" name="nom" id="nom" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required="" >
                                </div>
                            <button type="submit" class="ml-[7rem] w-[8rem] text-white bg-gradient-to-r from-purple-400 via-purple-500 to-purple-600 hover:bg-gradient-to-br font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">Confirmer</button>
                        </form>
                    </div>
                </div>
            </div>
            <!-- /////////////////////////////////////////////////////////////////////////////////////////////////////////// -->
            <div id="tagsltion" class="hidden fixed left-[32rem] top-[-1rem] flex flex-col items-center justify-center px-6 py-8 mx-auto md:h-screen lg:py-0">
                <div class="w-full bg-white rounded-lg shadow dark:border md:mt-0 sm:max-w-md xl:pr-4 xl:p-0 dark:bg-gray-800 dark:border-gray-700">
                    <i id="xmarkcsltion2" class="fa-solid fa-xmark ml-[26rem] text-2xl cursor-pointer mt-[1.2rem]" style="color: #2e2e2e;"></i>
                    <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
                        <h1 class="text-xl font-bold leading-tight tracking-tight text-stone-700 md:text-2xl dark:text-white">
                            Créer Tags
                        </h1>
                        <form class="space-y-4 md:space-y-6" method="POST">
                            <input type="hidden" name="add_tag" value="1">
                                <div>
                                    <label for="nom" class="block mb-2 text-sm font-medium text-stone-700 dark:text-white">Nom</label>
                                    <input type="text" name="nom" id="nom" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required="" >
                                </div>
                            <button type="submit" class="ml-[7rem] w-[8rem] text-white bg-gradient-to-r from-purple-400 via-purple-500 to-purple-600 hover:bg-gradient-to-br font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">Confirmer</button>
                        </form>
                    </div>
                </div>
            </div>
            
            <div class="flex flex-col space-y-6 md:space-y-0 md:flex-row justify-between">
                <div class="mr-6">
                    <h1 class="text-4xl font-semibold mb-2">Dashboard</h1>
                </div>
                <div class="flex flex-wrap items-start justify-end -mb-3">
                    <button id="mdfiebttn" class="inline-flex px-5 py-3 text-white bg-green-600 hover:bg-green-700 focus:bg-green-700 rounded-md ml-6 mb-3">
                        <svg aria-hidden="true" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="flex-shrink-0 h-6 w-6 text-white -ml-1 mr-2">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                        Créer une Catégorie
                    </button>

                    <button id="tagbttn" class="inline-flex px-5 py-3 text-white bg-green-600 hover:bg-green-700 focus:bg-green-700 rounded-md ml-6 mb-3">
                        <svg aria-hidden="true" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="flex-shrink-0 h-6 w-6 text-white -ml-1 mr-2">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                        Créer un Tag
                    </button>
                </div>
            </div>

            <section class="grid md:grid-cols-2 xl:grid-cols-4 gap-6">
                <div class="flex items-center p-8 bg-white shadow rounded-lg">
                    <div class="inline-flex flex-shrink-0 items-center justify-center h-16 w-16 text-yellow-600 bg-yellow-100 rounded-full mr-6">
                    <svg aria-hidden="true" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="h-6 w-6">
                        <path fill="#fff" d="M12 14l9-5-9-5-9 5 9 5z" />
                        <path fill="#fff" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222" />
                    </svg>
                    </div>
                    <div>
                    <span class="block text-2xl font-bold"><?php echo $ttlEtudiant ?></span>
                    <span class="block text-gray-500">Etudiants</span>
                    </div>
                </div>
                <div class="flex items-center p-8 bg-white shadow rounded-lg">
                    <div class="inline-flex flex-shrink-0 items-center justify-center h-16 w-16 text-blue-600 bg-blue-100 rounded-full mr-6">
                    <svg aria-hidden="true" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="h-6 w-6">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                    </svg>
                    </div>
                    <div>
                    <span class="block text-2xl font-bold"><?php echo $ttlEnseignant ?></span>
                    <span class="block text-gray-500">Enseignants</span>
                    </div>
                </div>
                <div class="flex items-center p-8 bg-white shadow rounded-lg">
                    <div class="inline-flex flex-shrink-0 items-center justify-center h-16 w-16 text-green-600 bg-green-100 rounded-full mr-6">
                    <svg aria-hidden="true" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="h-6 w-6">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                    </svg>
                    </div>
                    <div>
                    <span class="block text-2xl font-bold"><?php echo $ttlCours ?></span>
                    <span class="block text-gray-500">Cours</span>
                    </div>
                </div>
                <div class="flex items-center p-8 bg-white shadow rounded-lg">
                    <div class="inline-flex flex-shrink-0 items-center justify-center h-16 w-16 text-purple-600 bg-purple-100 rounded-full mr-6">
                    <svg aria-hidden="true" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="h-6 w-6">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                    </div>
                    <div>
                    <span class="block text-2xl font-bold"><?php echo $ttlUsers ?></span>
                    <span class="block text-gray-500">Utilisateurs</span>
                    </div>
                </div>
            </section>

            <section class="grid md:grid-cols-2 xl:grid-rows-3 xl:grid-flow-col gap-6">

                <div class="row-span-3 bg-white shadow rounded-lg">
                    <div class="flex items-center justify-between px-6 py-5 font-semibold border-b border-gray-100">
                    <span>Les Catégories</span>
                    
                    </div>

                    <div class="overflow-y-auto" style="max-height: 24rem;">
                        <ul class="p-6 space-y-6">
                            <?php foreach($categoriess as $categories){ ?>
                            <li class="flex items-center">
                            <span class="font-bold text-gray-600"><?php echo htmlspecialchars($categories['Nom']) ?></span>
                            <button onclick="getIdCategorie(<?php echo $categories['ID']; ?>)" type="button" class="ml-auto text-white bg-red-700 hover:bg-red-800 font-medium rounded-lg text-sm px-2 py-2.5 me-2 mb-2">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                </svg>
                            </button>

                            </li>
                            <?php } ?>
                        </ul>
                    </div>

                </div>

                <!-- /////////////////////////////////////////////////////////// -->

                <div class="row-span-3 bg-white shadow rounded-lg">
                    <div class="flex items-center justify-between px-6 py-5 font-semibold border-b border-gray-100">
                    <span>Les Tags</span>
                    
                    </div>

                    <div class="overflow-y-auto" style="max-height: 24rem;">
                        <ul class="p-6 space-y-6">
                            <?php foreach($tagss as $tags){ ?>
                            <li class="flex items-center">
                            <span class="font-bold text-gray-600"><?php echo htmlspecialchars($tags['Nom']) ?></span>
                            <button onclick="getIdTags(<?php echo $tags['ID']; ?>)" type="button" class="ml-auto text-white bg-red-700 hover:bg-red-800 font-medium rounded-lg text-sm px-2 py-2.5 me-2 mb-2">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                </svg>

                            </button>

                            </li>
                            <?php } ?>
                        </ul>
                    </div>

                </div>
                
            </section>

        </main>
    </div>

    <script>
        const ctnr1 = document.getElementById("ctnrcsltion");
        const xmark1 = document.getElementById("xmarkcsltion");
        const bttnmdfie = document.getElementById("mdfiebttn");
        
        xmark1.addEventListener('click', function(){
            ctnr1.classList.add('hidden');
        });


        bttnmdfie.addEventListener('click', function(){
            ctnr1.classList.remove('hidden');
        });

        const tagctnr1 = document.getElementById("tagsltion");
        const xmark2 = document.getElementById("xmarkcsltion2");
        const bttntag = document.getElementById("tagbttn");
        
        xmark2.addEventListener('click', function(){
            tagctnr1.classList.add('hidden');
        });


        bttntag.addEventListener('click', function(){
            tagctnr1.classList.remove('hidden');
        });


        function getIdCategorie(categorie_ID_Supp) {
        document.getElementById("categorie_ID_Supp").value = categorie_ID_Supp;
        document.getElementById("supprimerCategorie").submit();
        };

        function getIdTags(tags_ID_Supp) {
        document.getElementById("tags_ID_Supp").value = tags_ID_Supp;
        document.getElementById("supprimerTags").submit();
        };
    </script>
</body>
</html>
