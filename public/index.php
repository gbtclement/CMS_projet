<?php
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
}

?>

