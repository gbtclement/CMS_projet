<?php

session_start();

require_once '../config/database.php';  // Inclusion du fichier de connexion à la base de données
require_once '../src/models/Page.php';  // Inclusion du modèle Page

// Utilisation de l'objet $pdo pour récupérer les pages
$pages = Page::getAll($pdo);

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
    case 'listPage':
        header("Location: ../src/views/ListPage.php");
        break;
    case 'createPage':
        header("Location: ../src/views/CreatePage.php");
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

?>

