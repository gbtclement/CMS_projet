<?php

session_start();
require_once '../src/config/database.php';
require_once '../src/controllers/pageController.php';
require_once '../src/controllers/userController.php';

$action = $_GET['action'] ?? 'goToHome';
$pdo = Database::getConnection();
$pageController = new PageController();
$userController = new UserController();

// Routage des actions
switch ($action) {
    case 'goToHome':
        $pageController->goToHome();
        break;
    case 'goToDashboard':
        $pageController->goToDashboard();
        break;
    case 'listPage':
        $pageController->listPages();
        break;
    case 'createPage':
        $pageController->createPage($pdo);
        break;
    case 'login':
        $userController->login();
        break;
    case 'logout':
        $userController->logout();
        break;
    case 'createUser':
        $userController->createUser();
        break;
    case 'deleteUser':
        $userController->deleteUser();
        break;
}
