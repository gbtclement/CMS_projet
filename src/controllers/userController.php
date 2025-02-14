<?php
require_once __DIR__ . '/../models/User.php';


class UserController {

    // Connexion
    public function login() {
        session_start();
    
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $username = $_POST['username'];
            $password = $_POST['password'];
            
            $user = User::findByUsername($username);
            $passhash = $user['password'];
    
            if ($user) {
                if (password_verify($password, $passhash)) {
                    $_SESSION['user'] = $user;
                    header('Location: ../pages/Home.php');
                    exit();
                } else {
                    echo "Identifiants incorrects";
                }
            } else {
                echo "Identifiants incorrects";
            }
        }
    }
    
    
    
    // Déconnexion
    public function logout() {
        $_SESSION = array();
        
        if (isset($_COOKIE[session_name()])) {
            setcookie(session_name(), '', time()-3600, '/');
        }
        
        session_destroy();
        
        header("Location: ../pages/Home.php");
        exit();
    }

    // Afficher tous les utilisaterus
    public function listUsers() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    
        if (!isset($_SESSION['user'])) {
            header('Location: ../pages/LoginView.php');
            exit();
        }
    
        if ($_SESSION['user']['role'] !== 'admin') {
            header('Location: ../pages/Home.php');
            exit();
        }
    
        $users = User::getAll();
        
        return $users;
    }
    
    //supprimer user et ses pages
    public function deleteUser() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
            header('Location: ../pages/Home.php');
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
    
                header('Location: ../src/views/admin/Dashboard.php');
                exit();
            } else {
                $_SESSION['error'] = "Impossible de supprimer un administrateur";
                header('Location: ../src/views/admin/Dashboard.php');
                exit();
            }
        }
    }

    //creer un utilisateur
    public function createUser() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
            header('Location: ../pages/Home.php');
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'];
            $password = $_POST['password'];
            $role = $_POST['role'];
            $passwordHash = password_hash($password, PASSWORD_DEFAULT);
            User::create($username, $passwordHash, $role);

            header('Location: ../src/views/admin/Dashboard.php');
            exit();
        }
    }
    
    
}

//crypter le mdp+
?>
