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
    <link rel="stylesheet" href="../../../public/assets/css/dashboard.css">
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
                            <th>Administration+</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($users as $user) : ?>
                            <style>
                                .delete-btn {
                                    background-color: #ff4b5c;
                                    color: #fff;
                                    border: none;
                                    border-radius: 5px;
                                    padding: 5px 10px;
                                    cursor: pointer;
                                    font-size: 14px;
                                    transition: background-color 0.3s ease;
                                    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
                                }

                                .delete-btn:hover {
                                    background-color: #e04352;
                                }
                            </style>
                            <tr>
                                <td><?= htmlspecialchars($user->getUsername()) ?></td>
                                <td><span class="role-badge"><?= htmlspecialchars($user->getRole()) ?></span></td>
                                <td><?= htmlspecialchars($user->getCreatedAt()) ?></td>
                                <td>
                                    <form action="../../../public/index.php?action=deleteUser" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?');">
                                         <input type="hidden" name="user_id" value="<?= htmlspecialchars($user->getId()) ?>">
                                        <button type="submit" class="delete-btn">Supprimer</button>
                                    </form>
                                </td>
                            </tr>
                         <?php endforeach; ?>
                    </tbody>
                </table>
                <?php if (isset($_SESSION['error'])): ?>
                    <style>
                        .error-message {
                            background-color: #ffebee;
                            color: #c62828;
                            padding: 10px;
                            margin: 10px 0;
                            border-radius: 4px;
                            border: 1px solid #ef9a9a;
                        }
                    </style>
                    <div class="error-message">
                        <?= htmlspecialchars($_SESSION['error']) ?>
                    </div>
                    <?php unset($_SESSION['error']); ?>
                <?php endif; ?>
            </div>
        <?php else: ?>
            <div class="empty-state">
                <p>Aucun utilisateur trouvé.</p>
            </div>
        <?php endif; ?>
            <div class="form-container">
                <h2>Créer un utilisateur</h2>
                <form action="../../../public/index.php?action=createUser" method="POST">
                    <div class="form-group">
                        <label for="username">Nom d'utilisateur :</label>
                        <input type="text" id="username" name="username" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="password">Mot de passe :</label>
                        <input type="password" id="password" name="password" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="role">Rôle :</label>
                        <select id="role" name="role" required>
                            <option value="user">Utilisateur</option>
                            <option value="admin">Administrateur</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <input type="submit" value="Créer l'utilisateur">
                    </div>
                </form>
</div>
    </div>
    

    <?php include '../Footer.php'?>
</body>
</html>
