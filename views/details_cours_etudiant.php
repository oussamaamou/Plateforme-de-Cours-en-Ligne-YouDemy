<?php

require '../classes/Database.php';
require '../Classes/Cours.php';

session_start();

if(!isset($_SESSION['ID'])){
    header('location: ../templates/login.php');
    exit();
}

$courseId = intval($_GET['id']);

$cours = new Cours("", "", "", "", "", "", "");
$course = $cours->getCours($courseId);

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

    <main class="overflow-hidden bg-white">
        
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
                <h2 class="text-3xl font-bold mb-2"><?php echo htmlspecialchars($course['Titre']) ?></h2>
                <p class="text-white-600 mb-4"><?php echo htmlspecialchars($course['Date_creation']) ?></p>

                <p class="text-white-700 mb-6"><?php echo htmlspecialchars($course['Description']) ?></p>

                </div>
            </div>
            </div>
        </div>
        <hr class="h-[0.1rem] w-full mx-4 bg-white border-0 dark:bg-gray-700">
        <section class="flex py-24 relative">
        <button onclick="" class="block items-center px-1 -ml-1 flex-column">
            <svg class="w-8 h-8 text-gray-600 cursor-pointer hover:text-purple-700" fill="none"
                stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5">
                </path>
            </svg>
            <span class="bg-green-100 text-green-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded-full dark:bg-green-900 dark:text-green-300"></span>
        </button>
        
        <div class="w-full max-w-7xl px-4 md:px-5 lg:px-5 mx-auto">
            
            <div class="w-full flex-col justify-start items-start lg:gap-14 gap-7 inline-flex">
                <h2 class="w-full text-gray-900 text-4xl font-bold font-manrope leading-normal">Comments</h2>
                <div class="w-full flex-col justify-start items-start gap-5 flex">
                    <div class="w-full rounded-3xl justify-start items-start gap-3.5 inline-flex">
                        <img class="w-10 h-10 object-cover" src="https://pagedone.io/asset/uploads/1710225753.png" alt="John smith image" />
                        <textarea name="" rows="5" class="w-full px-5 py-3 rounded-2xl border border-gray-300 shadow-[0px_1px_2px_0px_rgba(16,_24,_40,_0.05)] resize-none focus:outline-none placeholder-gray-400 text-gray-900 text-lg font-normal leading-7" placeholder="Write a your thoughts here...."></textarea>
                    </div>
                    <button class="px-5 py-2.5 bg-green-600 hover:bg-green-800 transition-all duration-700 ease-in-out rounded-xl shadow-[0px_1px_2px_0px_rgba(16,_24,_40,_0.05)] justify-center items-center flex">
                        <span class="px-2 py-px text-white text-base font-semibold leading-relaxed">Post your comment</span>
                    </button>
                </div>
                <div class="w-full flex-col justify-start items-start gap-8 flex">
                    <div class="w-full pb-6 border-b border-white justify-start items-start gap-2.5 inline-flex">
                        <img class="w-10 h-10 rounded-full object-cover" src="https://pagedone.io/asset/uploads/1710226776.png" alt="Mia Thompson image" />
                        <div class="w-full flex-col justify-start items-start gap-3.5 inline-flex">
                            <div class="w-full justify-start items-start flex-col flex gap-1">
                                <div class="w-full justify-between items-start gap-1 inline-flex">
                                    <h5 class="text-gray-900 text-sm font-semibold leading-snug">Mia Thompson</h5>
                                    <span class="text-right text-gray-700 text-xs font-normal leading-5">12 hour ago</span>
                                </div>
                                <h5 class="text-gray-800 text-sm font-normal leading-snug">In vestibulum sed aliquet id turpis. Sagittis sed sed adipiscing velit habitant quam. Neque feugiat consectetur consectetur turpis.</h5>
                            </div>
                            
                        </div>
                    </div>
                   
                </div>
            </div>
        </div>
    </section>
                                            

    </main>






</body>
</html>