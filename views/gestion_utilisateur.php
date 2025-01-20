<?php

require '../Classes/Database.php';
require '../Classes/Administrateur.php';
require '../Classes/Enseignant.php';
require '../Classes/Etudiant.php';


session_start();

if(!isset($_SESSION['ID'])){
    header('location: ../templates/login.php');
    exit();
}

$ID = $_SESSION['ID'];

$infos = new Administrateur('','','','','','','');
$enseignant = new Enseignant('','','','','','','');
$etudiant = new Etudiant('','','','','','','');

$profile = $infos->profileInfos($ID);

if ($profile) {
    $nom = $profile['Nom'];
    $prenom = $profile['Prenom'];
    $photo = $profile['Photo'];
    $role = $profile['Role'];
    $telephone = $profile['Telephone'];
    $email = $profile['Email'];
}

$enseignants = $enseignant->getAllEnseignants();
$etudiants = $etudiant->getAllEtudiants();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['accepter_demande'])) {
    $ID_utilisateur = $_POST['ID_accepter_demande'] ?? null;
    if ($ID_utilisateur) {
        $infos->accepterEnseignant($ID_utilisateur);
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['refuser_demande'])) {
    $ID_utilisateur = $_POST['ID_refuser_demande'] ?? null;
    if ($ID_utilisateur) {
        $infos->refuserEnseignant($ID_utilisateur);
    }
}



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
    
    <title>Postes</title>
</head>
<body class="flex bg-gray-100 min-h-screen">
    <aside class="hidden sm:flex sm:flex-col">
        <a href="#" class="inline-flex items-center justify-center h-20 w-20 hover:bg-purple-500 focus:bg-purple-500">
            <img src="../assets/images/YouDemy_Logo.png" alt="Site Web Logo" />
        </a>
        <div class="flex-grow flex flex-col justify-between text-gray-500 bg-gray-800">
        <nav class="flex flex-col mx-4 my-6 space-y-4">
            
            <a href="gestion_administrateur.php" class="inline-flex items-center justify-center py-3 hover:text-gray-400 hover:bg-gray-700 focus:text-gray-400 focus:bg-gray-700 rounded-lg">
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

            <a href="gestion_utilisateur.php" class="inline-flex items-center justify-center py-3 text-green-600 bg-white rounded-lg">
            <span class="sr-only">Utilisateur</span>
            <svg class="w-6 h-6 text-green-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 18 20">
                <path d="M16 0H4a2 2 0 0 0-2 2v1H1a1 1 0 0 0 0 2h1v2H1a1 1 0 0 0 0 2h1v2H1a1 1 0 0 0 0 2h1v2H1a1 1 0 0 0 0 2h1v1a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2Zm-5.5 4.5a3 3 0 1 1 0 6 3 3 0 0 1 0-6ZM13.929 17H7.071a.5.5 0 0 1-.5-.5 3.935 3.935 0 1 1 7.858 0 .5.5 0 0 1-.5.5Z"/>
            </svg>
            </a>

            <a href="article_administrateur.php" class="inline-flex items-center justify-center py-3 hover:text-gray-400 hover:bg-gray-700 focus:text-gray-400 focus:bg-gray-700 rounded-lg">
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
                    <span class="font-semibold"><?php echo $nom . ' ' . $prenom; ?></span>
                    <span class="text-sm text-gray-600"><?php echo $role; ?></span>
                </div>
                <span class="h-12 w-12 ml-2 sm:ml-3 mr-2 bg-gray-100 rounded-full overflow-hidden">
                    <img src="../assets//images/<?php echo $photo; ?>" alt="user profile photo" class="h-full w-full object-cover">
                </span>
            
                <div class="border-l pl-3 ml-3 space-x-1">
                    <button class="relative p-2 text-gray-400 hover:bg-gray-100 hover:text-gray-600 focus:bg-gray-100 focus:text-gray-600 rounded-full">
                    <a href="../public/logout.php">
                        <span class="sr-only">Log out</span>
                        <svg aria-hidden="true" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="h-6 w-6">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                    </a>
                    </button>
                </div>
            </div>
        </header>

        <!-- Accepter -->
        <form id="accepterDemande" method="POST" action="">
            <input type="hidden" name="accepter_demande" value="1">
            <input type="hidden" name="ID_accepter_demande" id="ID_accepter_demande" value="">
        </form>

        <!-- Refuser -->
        <form id="refuserDemande" method="POST" action="">
            <input type="hidden" name="refuser_demande" value="1">
            <input type="hidden" name="ID_refuser_demande" id="ID_refuser_demande" value="">
        </form>

        <main>

            <div class="bg-white p-8 rounded-md w-full">
                <div class="items-center justify-between pb-6">
                
                <h2 class="text-gray-600 font-semibold">Les Enseignants</h2>
                <span class="text-xs">Tous les Enseignants</span>
                
                <div>
                    <div class="-mx-4 sm:-mx-8 px-4 sm:px-8 py-4 overflow-x-auto">
                        <div class="inline-block min-w-full shadow rounded-lg overflow-hidden">
                            <table class="min-w-full leading-normal">
                                <thead>
                                    <tr>
                                        <th
                                            class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                            Nom
                                        </th>
                                        <th
                                            class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                            Role
                                        </th>
                                        <th
                                            class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                            Action
                                        </th>
                                        <th
                                            class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                            Action
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($enseignants as $enseignant){ ?>
                                    <tr>
                                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 w-10 h-10">
                                                    <img class="w-full h-full rounded-full"
                                                        src="../assets/images/<?php echo $enseignant['Photo'] ?>"
                                                        alt="Photo de Profile" />
                                                </div>
                                                    <div class="ml-3">
                                                        <p class="text-gray-900 whitespace-no-wrap">
                                                            <?php echo htmlspecialchars($enseignant['Nom']) . ' ' . htmlspecialchars($enseignant['Prenom']) ?>
                                                        </p>
                                                    </div>
                                                </div>
                                        </td>
                                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                            <p class="text-gray-900 whitespace-no-wrap"><?php echo htmlspecialchars($enseignant['Role']) ?></p>
                                        </td>
                                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                            <button onclick="refuserDemande(<?php echo $enseignant['ID']; ?>)" class="ml-auto text-white bg-red-700 hover:bg-red-800 font-medium rounded-lg text-sm px-2 py-2.5 me-2 mb-2" type="button">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M18.364 18.364A9 9 0 0 0 5.636 5.636m12.728 12.728A9 9 0 0 1 5.636 5.636m12.728 12.728L5.636 5.636" />
                                            </svg>
                                            </button>
                                        </td>
                                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                            <button onclick="accepterDemande(<?php echo $enseignant['ID']; ?>)" class="ml-auto text-white bg-green-700 hover:bg-green-800 font-medium rounded-lg text-sm px-2 py-2.5 me-2 mb-2" type="button">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4"> 
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" /> 
                                            </svg>
                                            </button>
                                        </td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white p-8 rounded-md w-full">
                <div class="items-center justify-between pb-6">
                
                <h2 class="text-gray-600 font-semibold">Les Etudiants</h2>
                <span class="text-xs">Tous les Etudiants</span>
                
                <div>
                    <div class="-mx-4 sm:-mx-8 px-4 sm:px-8 py-4 overflow-x-auto">
                        <div class="inline-block min-w-full shadow rounded-lg overflow-hidden">
                            <table class="min-w-full leading-normal">
                                <thead>
                                    <tr>
                                        <th
                                            class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                            Nom
                                        </th>
                                        <th
                                            class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                            Role
                                        </th>
                                        <th
                                            class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                            Action
                                        </th>
                                        <th
                                            class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                            Action
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($etudiants as $etudiant){ ?>
                                    <tr>
                                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 w-10 h-10">
                                                    <img class="w-full h-full rounded-full"
                                                        src="../assets/images/<?php echo $etudiant['Photo'] ?>"
                                                        alt="Photo de Profile" />
                                                </div>
                                                    <div class="ml-3">
                                                        <p class="text-gray-900 whitespace-no-wrap">
                                                            <?php echo htmlspecialchars($etudiant['Nom']) . ' ' . htmlspecialchars($etudiant['Prenom']) ?>
                                                        </p>
                                                    </div>
                                                </div>
                                        </td>
                                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                            <p class="text-gray-900 whitespace-no-wrap"><?php echo htmlspecialchars($etudiant['Role']) ?></p>
                                        </td>
                                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                            <button onclick="refuserDemande(<?php echo $etudiant['ID']; ?>)" class="ml-auto text-white bg-red-700 hover:bg-red-800 font-medium rounded-lg text-sm px-2 py-2.5 me-2 mb-2" type="button">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M18.364 18.364A9 9 0 0 0 5.636 5.636m12.728 12.728A9 9 0 0 1 5.636 5.636m12.728 12.728L5.636 5.636" />
                                            </svg>
                                            </button>
                                        </td>
                                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                            <button onclick="accepterDemande(<?php echo $etudiant['ID']; ?>)" class="ml-auto text-white bg-green-700 hover:bg-green-800 font-medium rounded-lg text-sm px-2 py-2.5 me-2 mb-2" type="button">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4"> 
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" /> 
                                            </svg>
                                            </button>
                                        </td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            

        </main>
    </div>

    <script>

        function accepterDemande(ID_accepter_demande) {
        document.getElementById("ID_accepter_demande").value = ID_accepter_demande;
        document.getElementById("accepterDemande").submit();
        };

        function refuserDemande(ID_refuser_demande) {
        document.getElementById("ID_refuser_demande").value = ID_refuser_demande;
        document.getElementById("refuserDemande").submit();
        };

    </script>

</body>
</html>
