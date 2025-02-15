<?php
require_once __DIR__ . '/../models/User.php';


class UserController
{

    // Connexion
    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $username = $_POST['username'];
            $password = trim($_POST['password']);  // Utilisation de trim pour supprimer les espaces
            $user = User::findByUsername($username);

            if ($user) {
                $passhash = trim($user['password']);  // Hash du mot de passe récupéré en base

                // Débogage : Affichage des valeurs pour comparaison
                var_dump($password);  // Mot de passe saisi
                var_dump($passhash);   // Hash en base

                // Vérification du mot de passe
                if (password_verify($password, $passhash)) {
                    $_SESSION['user'] = $user;
                    header('Location: index.php?action=goToHome');
                    exit();
                } else {
                    echo "Mot de passe incorrect. Vérification : ";
                    // Affichage des caractères sous forme hexadécimale pour tout vérifier
                    echo bin2hex($password) . "\n";  // Affiche le mot de passe saisi en hexadécimal
                    echo bin2hex($passhash) . "\n";  // Affiche le hash en hexadécimal

                    var_dump(password_verify($password, $passhash));  // Affiche le résultat de la vérification
                }
            } else {
                echo "Identifiants incorrects";
            }
        }
        include __DIR__ . '/../views/pages/LoginView.php';
    }





    // Déconnexion
    public function logout()
    {
        $_SESSION = array();

        if (isset($_COOKIE[session_name()])) {
            setcookie(session_name(), '', time() - 3600, '/');
        }

        session_destroy();

        header("Location: index.php?action=goToHome");
        exit();
    }

    // Afficher tous les utilisaterus
    public function listUsers()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['user'])) {
            header('Location: index.php?action=login');
            exit();
        }

        if ($_SESSION['user']['role'] !== 'admin') {
            header('Location: index.php?action=goToHome');
            exit();
        }

        $users = User::getAll();

        return $users;
    }

    //supprimer user et ses pages
    public function deleteUser()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
            header('Location: index.php?action=goToHome');
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['user_id'])) {
            $userId = $_POST['user_id'];

            $stmt = Database::getConnection()->prepare("SELECT role, username FROM users WHERE id = :id");
            $stmt->bindParam(':id', $userId, PDO::PARAM_INT);
            $stmt->execute();
            $userToDelete = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($userToDelete && $userToDelete['role'] !== 'admin') {
                $deletePagesStmt = Database::getConnection()->prepare("DELETE FROM pages WHERE id_user = :id_user");
                $deletePagesStmt->bindParam(':id_user', $userId, PDO::PARAM_INT);
                $deletePagesStmt->execute();

                User::deleteById($userId);

                header('Location: index.php?action=goToDashboard');
                exit();
            } else {
                $_SESSION['error'] = "Impossible de supprimer un administrateur";
                header('Location: index.php?action=goToDashboard');
                exit();
            }
        }
    }

    //creer un utilisateur
    public function createUser()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Vérification des droits d'accès
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
            header('Location: index.php?action=goToHome');
            exit();
        }

        // Traitement du formulaire d'ajout d'utilisateur
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'];
            $password = $_POST['password'];
            $role = $_POST['role'];

            // Hash du mot de passe
            $passwordHash = password_hash($password, PASSWORD_DEFAULT);

            // Sauvegarde dans la base de données
            User::create($username, $passwordHash, $role);

            // Vérification que le mot de passe a bien été hashé
            var_dump($passwordHash); // Ajoute ça pour vérifier le hash

            header('Location: index.php?action=goToDashboard');
            exit();
        }
    }
}

//crypter le mdp+
