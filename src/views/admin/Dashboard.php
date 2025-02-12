<?php 
require_once __DIR__ . '/../../controllers/UserController.php';
$controller = new UserController();
$users = $controller->listUsers();
?>

<?php include '../header.php'; ?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de bord - Administration</title>
    <link rel="stylesheet" href="../../../public/css/dashboard.css">
</head>
<body>
    <div class="container">
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