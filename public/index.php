<?php

session_start();
require_once '../src/config/database.php'; 
require_once '../src/controllers/pageController.php';

$action = $_GET['action'] ?? 'home';

// Routage des actions
switch ($action) {
    case 'home':
        header("Location: ../src/views/pages/Home.php");
        exit();
        break;
    case 'goToBo':
        header("Location: ../src/views/pages/AdminBackOfficeView.php");
        break;
    case 'listPage':
        header("Location: ../src/views/pages/ListPage.php");
        break;
    case 'createPage':
        header("Location: ../src/views/pages/CreatePage.php");
        break;
}

?>

