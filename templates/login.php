<?php 

require '../Classes/Database.php'; 
require '../Classes/Etudiant.php'; 

session_start();
 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $client = new Etudiant("","","","","","","");
    
    $client->setEmail($email = $_POST['email']);
    $mot_de_passe = $_POST['mot_de_passe'];
    
    if (!$client->loginUtilisateur($email, $mot_de_passe)) {
        $error_message = "Invalid Email ou Password.";
    }
    
}
    
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8"> 
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Lien du Tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Lien des Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css" integrity="sha512-5Hs3dF2AEPkpNAR7UiOHba+lRSJNeM2ECkwxUIxC1Q/FLycGTbNapWXB4tP889k5T5Ju8fs4b1P5z/iB4nMfSQ==" crossorigin="anonymous" referrerpolicy="no-referrer" /> 
    
    <title>Connexion</title>
</head>
<body>
    <main>
        <section class="bg-green-200">
            <div class="flex justify-center items-center font-[sans-serif] h-full min-h-screen p-4" style="background-image: url(); background-repeat: no-repeat; background-size: cover;">
                <div class="flex flex-col items-center justify-center px-6 py-8 mx-auto md:h-screen lg:py-0">
                    <div class="w-full bg-white rounded-lg shadow dark:border md:mt-0 sm:max-w-md xl:p-0 dark:bg-gray-800 dark:border-gray-700">
                        <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
                            <h1 class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-white">
                                Connectez-vous à votre compte
                            </h1>
                            <form class="space-y-4 md:space-y-6" method="POST">
                                <div>
                                    <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Votre Email</label>
                                    <input type="email" name="email" id="email" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="rachad@gmail.com" required="">
                                </div>
                                <div>
                                    <label for="mot_de_passe" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Votre Password</label>
                                    <input type="password" name="mot_de_passe" id="mot_de_passe" placeholder="••••••••" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required="">
                                </div>
                                <button type="submit" class="w-full text-white bg-green-500 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">Se connecter</button>
                                <p class="text-sm font-light text-gray-500 dark:text-gray-400">
                                    Je n'ai pas encore de compte? <a href="inscription.php" class="font-medium text-stone-700 hover:underline hover:text-green-500 dark:text-primary-500">S'inscrire</a>
                                </p>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </main>

    <script>

        function showAlert() {
            const alert = document.getElementById('alert');

            alert.style.display = 'block';

            alert.style.opacity = 1;
            alert.style.transition = 'opacity 1s ease-out';

            setTimeout(() => {
                alert.style.opacity = 0;
            }, 2000);

            setTimeout(() => {
                alert.style.display = 'none'; 
            }, 3000);
        }

        showAlert();

    </script>
</body>
</html>