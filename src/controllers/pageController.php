<?php

require_once __DIR__ . '/../models/Page.php';

$success = null;
$error = null;

class PageController
{
    // Dans votre pageController.php
    public function savePage()
    {
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
    public function createPage(PDO $pdo)
    {
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
        include __DIR__ . '/../views/pages/CreatePage.php';
    }

    // Modifier une page
    public function updatePage(PDO $pdo)
    {
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
    public function deletePage($pdo)
    {
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
    public function listPage()
    {
        $pages = Page::getAllPages();
        return $pages;
    }

    public function listPages()
    {
        include __DIR__ . '/../views/pages/ListPage.php';
    }

    public function goToHome(){
        include __DIR__ . '/../views/pages/Home.php';
    }

    public function goToBo(){
        include __DIR__ . '/../views/pages/AdminBackOfficeView.php';
    }

    public function goToDashboard(){
        include __DIR__ . '/../views/admin/Dashboard.php';
    }
}
