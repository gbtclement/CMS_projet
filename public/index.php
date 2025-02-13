<?php

session_start();

require_once '../src/config/database.php';  // Inclusion du fichier de connexion à la base de données
require_once '../src/controllers/pageController.php';

// Utilisation de l'objet $pdo pour récupérer les pages
$pages = Page::getAllPages($pdo);

$action = $_GET['action'] ?? 'connexion';

// Routage des actions
switch ($action) {
    case 'connexion':
        header("Location: ../src/views/ConnexionView.php");
        exit();
        break;
    case 'goToBo':
        header("Location: ../src/views/AdminBackOfficeView.php");
        break;

    case 'createPage':
        createPage($pdo);
        break;

    case 'updatePage':
        updatePage($pdo);
        break;

    case 'deletePage':
        deletePage($pdo);
        break;

    case 'listPage':
        listPage($pdo);
        break;
}





// --------------------------> Permet de lister les routes seulement utilisable pour les personnes connectés en tant que user classique <----------------------------

// if (isset($_SESSION['user_id'])) {
//     $utilisateur = User::readUtilisateur($pdo, $_SESSION['user_id']);
//     if ($utilisateur->getRole() === 'client') {
//         switch ($action) {
//             case 'listCategorie':
//             case 'createCategorie':
//             case 'updateCategorie':
//             case 'deleteCategorie':
//             case 'listProduit':
//             case 'createProduit':
//             case 'updateProduit':
//             case 'deleteProduit':
//             case 'listArticle':
//             case 'createArticle':
//             case 'updateArticle':
//             case 'deleteArticle':
//                 header("Location: ../src/views/accueil.php");
//                 exit();
//                 break;
//         }
//     }
// }
