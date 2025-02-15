<?php
require_once __DIR__ . '/../../controllers/UserController.php';

$controller = new UserController();
$users = $controller->listUsers();

// Récupérer l'utilisateur connecté
$currentUser = $_SESSION['user'] ?? null;
?>

<?php include __DIR__ . '/../header.php'; ?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de bord - Administration</title>
    <link rel="stylesheet" href="assets/css/dashboard.css">
    <link rel="stylesheet" href="assets/css/header.css">
</head>

<body>
    <div class="container">

        <div class="BO">
            <h1>Bonjour <?= htmlspecialchars($currentUser['username'] ?? 'Invité') ?></h1>
            <p>Votre rôle : <?= htmlspecialchars($currentUser['role'] ?? 'Non défini') ?></p>
            <div class="BO_access">
                <a class="btn" href="index.php?action=listPage">Voir les pages</a>
                <a class="btn" href="index.php?action=createPage">Créer une page</a>
            </div>
        </div>

        <h1>Liste des utilisateurs</h1>

        <?php if (isset($users) && !empty($users)): ?>
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>Nom d'utilisateur</th>
                            <th>Rôle</th>
                            <th>Date de création</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($users as $user) : ?>
                            <tr>
                                <td><?= htmlspecialchars($user->getUsername()) ?></td>
                                <td><span class="role-badge"><?= htmlspecialchars($user->getRole()) ?></span></td>
                                <td><?= htmlspecialchars($user->getCreatedAt()) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="empty-state">
                <p>Aucun utilisateur trouvé.</p>
            </div>
        <?php endif; ?>

    </div>
</body>

</html>
