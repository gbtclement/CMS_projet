<?php
require_once __DIR__ . '/../config/database.php';


$action = $_GET['action'] ?? 'connexion';

// Routage des actions
switch ($action) {
    case 'connexion':
        header("Location: ../src/views/pages/LoginView.php");
        exit();
        break;
}

?>

