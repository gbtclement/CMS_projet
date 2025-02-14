<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../src/controllers/UserController.php';  // Correction de "conrollers" -> "controllers"

// Création d'une instance du contrôleur UserController
$controller = new UserController();

$action = $_GET['action'] ?? 'home';

// Routage des actions
switch ($action) {
    case 'home':
        header("Location: ../src/views/pages/Home.php");
        exit();
        break;
    case 'createUser':
        $controller->createUser();
        break;
    case 'deleteUser':
        $controller->deleteUser();
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
?>
