<?php

include __DIR__ . '/../config/database.php';
include __DIR__ . '/../models/Page.php';

$success = null;
$error = null;

// Dans votre pageController.php
function savePage() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $data = json_decode(file_get_contents('php://input'), true);
        
        if ($data) {
            // Récupérer les données
            $title = $data['title'];
            $content = $data['content'];
            
            // Sauvegarder dans la base de données
            // Utilisez votre modèle Page pour sauvegarder
            
            echo json_encode(['success' => true]);
            return;
        }
    }
    
    echo json_encode(['success' => false, 'error' => 'Invalid request']);
}
// Ajouter une page
function createPage(PDO $pdo) {
    global $error;
    if (isset($_POST['submit'])) {
        $title = $_POST['title'] ?? null;
        $content = $_POST['content'] ?? null;

        if ($title && $content) {
            if (Page::createPage($pdo, $title, $content)) { // Appel correct de la méthode statique
                header('Location: index.php?action=listPage');
                exit();
            } else {
                $error = "Une erreur est survenue lors de la création de la page.";
            }
        } else {
            $error = "Le titre et le contenu de la page sont requis.";
        }
    }
    include __DIR__ . '/../views/CreatePage.php';
}

// Modifier une page
function updatePage(PDO $pdo) {
    global $error;
    if (isset($_POST['update'])) {
        $id = $_POST['id'] ?? null;
        $title = $_POST['title'] ?? null;
        $content = $_POST['content'] ?? null;

        if ($id && $title && $content) {
            if (Page::updatePage($pdo, $id, $title, $content)) { // Appel correct de la méthode statique
                header('Location: index.php?action=listPage');
                exit();
            } else {
                $error = "Une erreur est survenue lors de la mise à jour de la page.";
            }
        } else {
            $error = "Veuillez sélectionner une page et fournir un nouveau titre et contenu.";
        }
    }
}


// Supprimer des pages
function deletePage($pdo) {
    global $error;
    if (isset($_POST['delete'])) {
        $pagesToDelete = $_POST['pages'] ?? [];
        if (!empty($pagesToDelete)) {
            foreach ($pagesToDelete as $pageId) {
                Page::deletePage($pdo, $pageId);
            }
            header('Location: index.php?action=listPage');
            exit();
        } else {
            $error = "Veuillez sélectionner au moins une page à supprimer.";
        }
    }
}

// Récupérer toutes les pages pour l'affichage
function listPage($pdo) {
    global $success, $error;
    $pages = Page::getAllPages($pdo);
    include __DIR__ . '/../views/ListPage.php';
}

?>
