<?php require_once __DIR__ . '/../../controllers/pageController.php'; ?>
<?php include __DIR__ . '/../../views/header.php'; ?>

<div class="createPage">
    <div class="container">
        <h2>Créer une nouvelle page</h2>

        <?php if (isset($error)) : ?>
            <p class="error"> <?= htmlspecialchars($error) ?> </p>
        <?php endif; ?>

        <form action="index.php?action=createPage" method="POST">
            <label for="title">Titre :</label>
            <input type="text" id="title" name="title" required>

            <label for="content">Contenu :</label>
            <textarea id="content" name="content" required></textarea>

            <button type="submit" name="submit">Créer</button>
        </form>
    </div>
</div>

<?php include __DIR__ . '/../../views/footer.php'; ?>