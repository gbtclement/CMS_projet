<?php

if (session_status() === PHP_SESSION_NONE){
    session_start();
}

require_once __DIR__ . '/../controllers/UserController.php';
$controller = new UserController();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $controller->logout();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../../public/assets/css/header.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <title>Prestaflop</title>
</head>
<body>
    <header>
        <div class="menu">
            <div class="brand">
                Prestaflop
            </div>
            <div class="navigation" id="navigation">
                <a href="../pages/Home.php" class="icon svg">
                    Accueil
                </a>
                <?php if (session_status() === PHP_SESSION_ACTIVE && isset($_SESSION['user']['role']) && $_SESSION['user']['role'] == 'admin'): ?>
                    <a href="../admin/Dashboard.php" class="icon svg">
                        Dashboard
                    </a>
                <?php endif; ?>
                <a href="../pages/AdminBackOfficeView.php" class="icon svg">
                    Bo
                </a>
                <a href="../pages/ListPage" class="icon svg">
                    Pages
                </a>
            </div>
            <div class="auth">
                <?php if (isset($_SESSION['user'])): ?>
                    <form method="POST" class="logout-form">
                        <button type="submit" class="logout-btn">
                            Déconnexion
                        </button>
                    </form>
                <?php else: ?>
                    <a href="../pages/LoginView.php" class="icon svg">
                        Connexion
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </header>
<main>