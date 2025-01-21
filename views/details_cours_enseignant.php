<?php

require '../classes/Database.php';
require '../Classes/Cours.php';
require '../Classes/Enseignant.php';
require '../Classes/Commentaire.php';
require '../Classes/Categorie.php';
require '../Classes/Tags.php';

session_start();

if(!isset($_SESSION['ID'])){
    header('location: ../templates/login.php');
    exit();
}
$ID_enseignant = $_SESSION['ID'];

$courseId = intval($_GET['id']);

$cours = new Cours("", "", "", "", "", "", "");
$enseignant = new Enseignant('','','','','','','');
$categorie = new Categorie("");
$tag = new Tags("");
$comment = new Commentaire($ID_enseignant, $courseId, '');

$course = $cours->getCours($courseId);

$ttlEtudiants = $enseignant->ttlInscritsCours($courseId);

$commentss = $comment->getCommentsByCours();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['supprimer_cours'])) {
    $cours->supprimerCours($courseId);

    header("Location: cours_enseignant.php");
    exit();  
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['modifier_cours'])) {
    
    $cours->setEnseignant($ID_enseignant);
    $cours->setCategorie($ID_categorie = $_POST['categorie']);
    $cours->setType($type = $_POST['type']);
    $cours->setTitre($titre = $_POST['titre']);
    $cours->setContenu($contenu = $_POST['contenu']);
    $cours->setDescription($description = $_POST['description']);

    $cours->setThumbnail($thumbnail = null);
    if (isset($_FILES['thumbnail']) && $_FILES['thumbnail']['error'] == 0) {
        $fileTmpPath = $_FILES['thumbnail']['tmp_name'];
        $fileName = $_FILES['thumbnail']['name'];
        $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        
        $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
        
        if (in_array($fileExtension, $allowedExtensions)) {
            
            $uploadDir = '../assets/images/';

            $newFileName = uniqid('image_', true) . '.' . $fileExtension;
            $uploadPath = $uploadDir . $newFileName;

            if (move_uploaded_file($fileTmpPath, $uploadPath)) { 
                $cours->setThumbnail($thumbnail = $newFileName);
                
            }
        }
    }

    $cours->modifierCours($courseId);
}

$categoriess = $categorie->getAllCategorie();
$tagss = $tag->getAllTags();
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
                            <a href="profile_enseignant.php" class="block py-2 pr-4 pl-3 text-stone-700 rounded bg-primary-700 lg:bg-transparent lg:text-primary-700 lg:p-0 dark:text-white" aria-current="page">Profile</a>
                        </li>
                        <li>
                            <a href="cours_enseignant.php" class="block py-2 pr-4 pl-3 text-stone-700 border-b border-gray-100 hover:bg-gray-50 lg:hover:bg-transparent lg:border-0 lg:hover:text-primary-700 lg:p-0 dark:text-gray-400 lg:dark:hover:text-white dark:hover:bg-gray-700 dark:hover:text-white lg:dark:hover:bg-transparent dark:border-gray-700">Mes Cours</a>
                        </li>
                        <li>
                            <a href="gestion_cours_enseignant.php" class="block py-2 pr-4 pl-3 text-stone-700 border-b border-gray-100 hover:bg-gray-50 lg:hover:bg-transparent lg:border-0 lg:hover:text-primary-700 lg:p-0 dark:text-gray-400 lg:dark:hover:text-white dark:hover:bg-gray-700 dark:hover:text-white lg:dark:hover:bg-transparent dark:border-gray-700">Gestion</a>
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

    <!-- Cours Form-->
    <div id="postform" class="hidden fixed left-[32rem] top-[0rem] flex flex-col items-center justify-center px-6 py-8 mx-auto md:h-screen lg:py-0">
        <div class="w-full bg-white rounded-lg shadow dark:border md:mt-0 sm:max-w-md xl:pr-4 dark:bg-gray-800 dark:border-gray-700">
            <i id="xmarkcsltion2" class="fa-solid fa-xmark ml-[26rem] text-2xl cursor-pointer mt-[1.2rem]" style="color: #2e2e2e;"></i>
            <div class="space-y-6 py-8 px-10">
                <h1 class="text-xl mt-[-2rem] font-bold leading-tight tracking-tight text-stone-700 md:text-2xl dark:text-white">
                    Modifier votre Cours 
                </h1>
                <form class="space-y-1" method="POST" enctype="multipart/form-data">
                    
                    <input type="hidden" name="modifier_cours" value="1">
                    <div>
                        <label for="titre" class="block mb-2 text-sm font-medium text-stone-700 dark:text-white">Titre</label>
                        <input type="text" name="titre" id="titre" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required="" >
                    </div>
                    <div>
                        <label for="description" class="block mb-2 text-sm font-medium text-stone-700 dark:text-white">Description</label>
                        <textarea name="description" id="description" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Écrivez votre biographie ici..."></textarea>
                    </div>
                    <div class="grid gap-6 mb-6 md:grid-cols-2">
                        <div>
                            <label for="type" class="block mb-2 text-sm font-medium text-stone-700 dark:text-white">Type </label>
                            <select id="type" name="type" class="bg-gray-50 border border-gray-300 text-gray-900 mb-6 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                <option value="1">Video</option>
                                <option value="2">Document</option>
                                
                            </select>
                        </div>
                        <div>
                            <label for="categorie" class="block mb-2 text-sm font-medium text-stone-700 dark:text-white">Categorie</label>
                            <select id="categorie" name="categorie" class="bg-gray-50 border border-gray-300 text-gray-900 mb-6 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                <?php foreach($categoriess as $categories){ ?>
                                <option value="<?php echo htmlspecialchars($categories['ID']) ?>"><?php echo htmlspecialchars($categories['Nom']) ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div>
                        <label for="contenu" class="block mb-2 text-sm font-medium text-stone-700 dark:text-white">Contenu</label>
                        <input type="text" id="contenu" name="contenu" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required="" >
                    </div>
                    <div>
                        <label class="block mb-2 text-sm font-medium text-stone-700 dark:text-white" for="thumbnail">Thumbnail</label>
                        <input name="thumbnail" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-[7px] dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" type="file">
                    </div>
                    <div>
                        <label for="tag" class="block mb-2 text-sm font-medium text-stone-700 dark:text-white">Tags</label>
                        <select id="tag" name="tag" class="bg-gray-50 border border-gray-300 text-gray-900 mb-6 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            <?php foreach($tagss as $tags){ ?>
                            <option value="<?php echo htmlspecialchars($tags['ID']) ?>"><?php echo htmlspecialchars($tags['Nom']) ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    
                    <button type="submit" class="ml-[7rem] mt-[5rem] w-[8rem] text-white bg-gradient-to-r from-yellow-400 via-yellow-500 to-yellow-600 hover:bg-gradient-to-br font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">Modifier</button>
                </form>
            </div>
        </div>
    </div>

    <main class="overflow-hidden bg-white">
        
        <!-- Cours Details-->
        <div >
            <div class="container mx-auto px-4 py-8">
                <div class="flex">
                    <button id="ajtpost" type="button" class="ml-[84rem] text-white bg-yellow-300 hover:bg-yellow-400 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:focus:ring-yellow-900">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                        </svg>

                    </button>

                    <form id="" method="POST">
                        <input type="hidden" name="supprimer_cours" value="1">

                        <button class="text-white bg-red-500 hover:bg-red-600 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:focus:ring-red-900">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                            </svg>


                        </button>
                    </form>
            
                </div>
            <div class="flex flex-wrap -mx-4">
                
                <div class="w-full md:w-1/2 px-4 mb-8">
                    <iframe width="725" height="450"
                    src="<?php echo htmlspecialchars($course['Contenu']) ?>">
                    </iframe>
                </div>

                <div class="w-full md:w-1/2 px-4">
                    <div class="min-w-0 rounded-lg shadow-xs overflow-hidden bg-white dark:bg-gray-800">
                        <div class="p-4 flex items-center">
                            <div class="p-3 rounded-full text-red-500 dark:text-red-100 bg-red-600 dark:bg-red-500 mr-4">
                                <svg fill="white" viewBox="0 0 20 20" class="w-5 h-5">
                                <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z">
                                </path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-700 dark:text-gray-400">
                                    Etudiants inscrits
                                </p>
                                <p class="text-lg font-semibold text-gray-700 dark:text-gray-200">
                                    <?php echo $ttlEtudiants ?>
                                </p>
                            </div>
                        </div>
                    </div>

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

   

    <script>
        function coursInscription(ID_cours) {
        document.getElementById("ID_cours").value = ID_cours;
        document.getElementById("coursInscription").submit();
        };

        const ctnr2 = document.getElementById("postform");
        const xmark2 = document.getElementById("xmarkcsltion2");
        const ajtpost = document.getElementById("ajtpost");
        const dropdownbutton = document.getElementById("dropdown-button");
        const dropdown1 = document.getElementById("dropdown-1");
        
        xmark2?.addEventListener('click', function(){
            ctnr2.classList.add('hidden');
        });


        ajtpost?.addEventListener('click', function(){
            ctnr2.classList.remove('hidden');
        });

        dropdownbutton?.addEventListener('click', function(){
            dropdown1.classList.remove('hidden');
        });

        dropdownbutton?.addEventListener('dblclick', function(){
            dropdown1.classList.add('hidden');
        });

        document.addEventListener('DOMContentLoaded', function() {
            
            const morecmntButtons = document.querySelectorAll("#morecmnt");
            const lesscmntButtons = document.querySelectorAll("#lesscmnt");
            const cmntSections = document.querySelectorAll("#cmntsction");

            morecmntButtons.forEach((button, index) => {
                button.addEventListener('click', function() {
                    cmntSections[index].classList.remove('hidden');
                    button.classList.add('hidden'); 
                    lesscmntButtons[index].classList.remove('hidden');
                });
            });

            lesscmntButtons.forEach((button, index) => {
                button.addEventListener('click', function() {
                    cmntSections[index].classList.add('hidden');
                    button.classList.add('hidden'); 
                    morecmntButtons[index].classList.remove('hidden');
                });
            });
        });
    </script>
</body>
</html>