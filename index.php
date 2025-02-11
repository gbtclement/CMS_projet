<?php
require_once 'config/database.php';
require_once 'models/Page.php';

$pageModel = new Page($pdo);
$pages = $pageModel->getAllPages();
?>

<h1>Bienvenue sur le CMS</h1>
<ul>
    <?php foreach ($pages as $page) : ?>
        <li><a href="views/pages/page.php?id=<?= $page['id'] ?>"><?= htmlspecialchars($page['title']) ?></a></li>
    <?php endforeach; ?>
</ul>
