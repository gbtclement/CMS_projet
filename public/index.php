<?php
require_once '../config/database.php';  // Inclusion du fichier de connexion à la base de données
require_once '../src/models/Page.php';  // Inclusion du modèle Page

// Utilisation de l'objet $pdo pour récupérer les pages
$pages = Page::getAll($pdo);

?>

<h1>Bienvenue sur le CMS</h1>
<ul>
    <?php foreach ($pages as $page) : ?>
        <li><a href="views/pages/page.php?id=<?= $page->getId() ?>"><?= htmlspecialchars($page->getTitle()) ?></a></li>
    <?php endforeach; ?>
</ul>
