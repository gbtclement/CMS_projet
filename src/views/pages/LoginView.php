<?php
require_once __DIR__ . '/../../controllers/UserController.php';
$controller = new UserController();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $controller->login();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <link rel="stylesheet" href="../../../public/assets/css/login.css">
</head>
<body>

    <div class="login-container">
        <h1>Connexion</h1>
        <form method="POST">
            <input type="text" name="username" placeholder="Nom d'utilisateur" required>
            <input type="password" name="password" placeholder="Mot de passe" required>
            <button type="submit">Se connecter</button>
        </form>
    </div>

</body>
</html>
