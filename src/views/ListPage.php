<?php require_once __DIR__ . '/../controllers/pageController.php'; ?>
<?php include 'header.php'; ?>

<?php


echo "<div class='title'><h1 class='titlePage'>liste page</h1></div>";


foreach ($pages as $page): ?>


    <div class="listPages">
        <div class="idPages">
            <?= $page->getId(); ?>
        </div>
        <div class="infoPages">
            <?= htmlspecialchars($page->getTitle()); ?>
            <?= htmlspecialchars($page->getContent()); ?>
        </div>
    </div>

<?php endforeach;

?>

<?php include 'footer.php'; ?>