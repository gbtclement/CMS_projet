<?php
require_once __DIR__ . '/../config/database.php';


$action = $_GET['action'] ?? 'connexion';

// Routage des actions
switch ($action) {
    case 'connexion':
        header("Location: ../src/views/pages/LoginView.php");
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

?>

