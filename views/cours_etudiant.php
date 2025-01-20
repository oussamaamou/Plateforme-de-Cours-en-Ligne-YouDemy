<?php

require '../classes/Database.php';
require '../Classes/Cours.php';
require '../Classes/Categorie.php';
require '../Classes/Tags.php';
require '../Classes/Etudiant.php';

session_start();

if(!isset($_SESSION['ID'])){
    header('location: ../templates/login.php');
    exit();
}

$cours = new Cours("", "", "", "", "", "", "");
$user = new Etudiant("", "", "", "", "", "", "");
$category = new Categorie(""); 
$tagss = new Tags("");
$etudiant = new Etudiant("","","","","","",""); 

$page = isset($_GET['page']) ? intval($_GET['page']) : 1;

$coursPerPage = 4;

$courses = $user->consulterAllCours($page, $coursPerPage);
$categories = $category->getAllCategorie();
$tags = $tagss->getAllTags();

$searchTerm = isset($_POST['search']) ? $_POST['search'] : '';

if ($searchTerm) {
    $courses = $etudiant->rechercherCours($searchTerm);
}

$categoryFilter = isset($_POST['category_filter']) ? $_POST['category_filter'] : '';

if ($categoryFilter) {
    $courses = $category->filtrerCours($categoryFilter);
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
    
    <title>Les Cours</title>
</head>
<body class="bg-gradient-to-t from-green-400 via-green-300 to-green-200">

    <header class="mb-[3rem]">
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

    <!-- Filtrage les Resultats-->
    <form method="POST" class="flex rounded-md border-2 border-green-400 mt-[2rem] overflow-hidden max-w-md mx-auto">
        <input type="text" name="search" placeholder="Rechercher quelque chose..."
        class="w-full outline-none bg-white text-gray-600 text-sm px-4 py-3" />
        <button type='submit' class="flex items-center justify-center bg-green-400  px-5">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 192.904 192.904" width="16px" class="fill-white">
            <path
            d="m190.707 180.101-47.078-47.077c11.702-14.072 18.752-32.142 18.752-51.831C162.381 36.423 125.959 0 81.191 0 36.422 0 0 36.423 0 81.193c0 44.767 36.422 81.187 81.191 81.187 19.688 0 37.759-7.049 51.831-18.751l47.079 47.078a7.474 7.474 0 0 0 5.303 2.197 7.498 7.498 0 0 0 5.303-12.803zM15 81.193C15 44.694 44.693 15 81.191 15c36.497 0 66.189 29.694 66.189 66.193 0 36.496-29.692 66.187-66.189 66.187C44.693 147.38 15 117.689 15 81.193z">
            </path>
        </svg>
        </button>
    </form>

    <div class="grid grid-cols-2">

        <form method="POST" class="flex rounded-md border-2 border-green-400 mt-[2rem] overflow-hidden max-w-md mx-auto">
            <select name="category_filter" class="w-full outline-none bg-white text-gray-600 text-sm px-4 py-3">
                <option value="">Filtrer par catégorie</option>
                <?php
                foreach ($categories as $categorie) {
                    echo "<option value='" . $categorie['ID'] . "'>" . htmlspecialchars($categorie['Nom']) . "</option>";
                }
                ?>
            </select>
            <button type='submit' class="flex items-center justify-center bg-green-400 px-5">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 192.904 192.904" width="16px" class="fill-white">
                    <path d="m190.707 180.101-47.078-47.077c11.702-14.072 18.752-32.142 18.752-51.831C162.381 36.423 125.959 0 81.191 0 36.422 0 0 36.423 0 81.193c0 44.767 36.422 81.187 81.191 81.187 19.688 0 37.759-7.049 51.831-18.751l47.079 47.078a7.474 7.474 0 0 0 5.303 2.197 7.498 7.498 0 0 0 5.303-12.803zM15 81.193C15 44.694 44.693 15 81.191 15c36.497 0 66.189 29.694 66.189 66.193 0 36.496-29.692 66.187-66.189 66.187C44.693 147.38 15 117.689 15 81.193z"></path>
                </svg>
            </button>
        </form>

        <form method="POST" class="flex rounded-md border-2 border-green-400 mt-[2rem] overflow-hidden max-w-md mx-auto">
            <select name="tag_filter" class="w-full outline-none bg-white text-gray-600 text-sm px-4 py-3">
                <option value="">Filtrer par tag</option>
                <?php
                foreach ($tags as $tag) {
                    echo "<option value='" . $tag['ID'] . "'>" . htmlspecialchars($tag['Nom']) . "</option>";
                }
                ?>
            </select>
            <button type='submit' class="flex items-center justify-center bg-green-400 px-5">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 192.904 192.904" width="16px" class="fill-white">
                    <path d="m190.707 180.101-47.078-47.077c11.702-14.072 18.752-32.142 18.752-51.831C162.381 36.423 125.959 0 81.191 0 36.422 0 0 36.423 0 81.193c0 44.767 36.422 81.187 81.191 81.187 19.688 0 37.759-7.049 51.831-18.751l47.079 47.078a7.474 7.474 0 0 0 5.303 2.197 7.498 7.498 0 0 0 5.303-12.803zM15 81.193C15 44.694 44.693 15 81.191 15c36.497 0 66.189 29.694 66.189 66.193 0 36.496-29.692 66.187-66.189 66.187C44.693 147.38 15 117.689 15 81.193z"></path>
                </svg>
            </button>
        </form>
    </div>
    <main class="overflow-hidden">  
        <div class="grid grid-cols-2 gap-4">
        <?php foreach($courses as $course) { ?>
        <div class="scale-[0.9] mt-[4rem] bg-white dark:bg-gray-800 rounded-xl shadow-2xl max-w-4xl w-full p-4 transition-all duration-300 animate-fade-in pt-[3.5rem]">
            <div class="flex flex-row">
                <div class="w-1/3 text-center mb-0">
                    <img src="../assets/images/<?php echo $course['photo_utilisateur'] ?>" alt="Profile Picture" class="rounded-full w-48 h-48 mx-auto mb-4 border-4 border-green-500 transition-transform duration-300 hover:scale-105">
                    <h1 class="text-2xl font-bold text-green-500 dark:text-white mb-2"></h1>
                    <p class="text-stone-700 font-semibold"><?php echo htmlspecialchars($course['nom_utilisateur']) . ' ' . htmlspecialchars($course['prenom_utilisateur']); ?></p>
                    

                    <h2 class="text-xl font-semibold text-green-500 mb-4  mt-[3rem]">Catégorie</h2>
                    <p class="text-stone-700 font-semibold"><?php echo htmlspecialchars($course['categorie_nom']) ?></p>
                    
                    <a  href='details_cours_etudiant.php?id=<?php echo $course['ID']; ?>'>
                        <button class="ml-[5.7rem] mt-[5rem] flex items-center rounded-md border border-green-300 py-2 px-4 text-center text-sm transition-all shadow-sm hover:shadow-lg text-green-600 hover:text-white hover:bg-green-800 hover:border-green-800 focus:text-white focus:bg-green-800 focus:border-green-800 active:border-green-800 active:text-white active:bg-green-800 disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none" type="button">
                            Details
                            
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4 ml-1.5">
                                <path fill-rule="evenodd" d="M16.28 11.47a.75.75 0 0 1 0 1.06l-7.5 7.5a.75.75 0 0 1-1.06-1.06L14.69 12 7.72 5.03a.75.75 0 0 1 1.06-1.06l7.5 7.5Z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </a>
                </div>
                <div class="w-2/3 pl-8">
                    <p class="text-gray-700 font-semibold text-2xl dark:text-gray-300 mb-6"> <?php echo htmlspecialchars($course['Titre']) ?></p>
                    <div class="grid min-h-[140px] w-full place-items-center overflow-x-scroll rounded-lg lg:overflow-visible">
                    <img class="h-[25rem]"
                        src="../assets/images/<?php echo($course['Thumbnail']) ?>">
                    </div>
                    <p class="text-gray-700 dark:text-gray-300 mb-6 mt-6">
                    <?php echo htmlspecialchars($course['Description']) ?>
                    </p>
                </div>
            </div>

            <div class="mb-[0.5rem] overflow-hidden">
                <hr class="h-px w-[50rem] my-4 bg-gray-200 border-0 dark:bg-gray-700">

                <svg id="morecmnt" class="w-4 h-4 text-green-700 cursor-pointer" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 16 10">
                    <path d="M15.434 1.235A2 2 0 0 0 13.586 0H2.414A2 2 0 0 0 1 3.414L6.586 9a2 2 0 0 0 2.828 0L15 3.414a2 2 0 0 0 .434-2.179Z"/>
                </svg>
                <svg id="lesscmnt" class="w-4 h-4 text-green-700 cursor-pointer hidden" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 10 16">
                    <path d="M3.414 1A2 2 0 0 0 0 2.414v11.172A2 2 0 0 0 3.414 15L9 9.414a2 2 0 0 0 0-2.828L3.414 1Z"/>
                </svg>
            </div>

        </div>
        <?php } ?>
        </div>
     

    </main>

    <div class="bg-white rounded-lg p-4 flex items-center flex-wrap">
        <nav aria-label="Page navigation">
            <ul class="inline-flex">
            <a href="?page=<?php echo max($page - 1, 1); ?>">
                <li><button class="h-10 px-5 text-green-600 transition-colors duration-150 rounded-l-lg focus:shadow-outline hover:bg-green-100">
                    <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20"><path d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" fill-rule="evenodd"></path></svg></button>
                </li>
            </a>

            <li><button class="h-10 px-5 text-green-600 transition-colors duration-150 focus:shadow-outline hover:bg-green-100">1</button></li>
            <li><button class="h-10 px-5 text-white transition-colors duration-150 bg-green-600 border border-r-0 border-green-600 focus:shadow-outline">2</button></li>
            <li><button class="h-10 px-5 text-green-600 transition-colors duration-150 focus:shadow-outline hover:bg-green-100">3</button></li>
           
            <a href="?page=<?php echo $page + 1; ?>">
                <li><button class="h-10 px-5 text-green-600 transition-colors duration-150 bg-white rounded-r-lg focus:shadow-outline hover:bg-green-100">
                    <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20"><path d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" fill-rule="evenodd"></path></svg></button>
                </li>
            </a>
            </ul>
        </nav>
    </div>

    <footer class="bg-white rounded-lg shadow dark:bg-gray-900 m-4">
        <div class="w-full max-w-screen-xl mx-auto p-4 md:py-8">
            <div class="sm:flex sm:items-center sm:justify-between">
                <a class="flex items-center mb-4 sm:mb-0 space-x-3 rtl:space-x-reverse">
                    <img src="../assets/images/YouDemy_Logo.png" class="mb-[-2rem] w-[7rem]" alt="Flowbite Logo" />
                </a>
                <ul class="flex flex-wrap items-center mb-6 text-sm font-medium text-gray-500 sm:mb-0 dark:text-gray-400">
                    <li>
                        <a href="https://oussamaamou.github.io/PortFolio-HTML-CSS-JS/" target="_blank" class="hover:underline me-4 md:me-6">About</a>
                    </li>
                    <li>
                        <a href="https://www.youcode.ma/" target="_blank" class="hover:underline me-4 md:me-6">Licensing</a>
                    </li>
                    <li>
                        <a href="https://www.linkedin.com/in/oussama-amou-b71151337/" target="_blank" class="hover:underline">Contact</a>
                    </li>
                </ul>
            </div>
            <hr class="my-6 border-gray-200 sm:mx-auto dark:border-gray-700 lg:my-8" />
            <span class="block text-sm text-gray-500 sm:text-center dark:text-gray-400">© 2024 <a href="https://flowbite.com/" class="hover:underline">YouDemy Education</a>. Tous droits réservés.</span>
        </div>
    </footer>



    <script>
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