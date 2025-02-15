<?php require_once __DIR__ . '/../../controllers/pageController.php'; ?>
<?php include __DIR__ . '/../header.php'; ?>


<?php
$controller = new PageController();
$pages = $controller->listPage();


?><div class="listPage"><?php
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
</div>

<?php include __DIR__ . '/../footer.php'; ?>