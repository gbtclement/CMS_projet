<?php
require_once __DIR__ . '/../models/User.php';


class UserController {

    // Connexion
    public function login() {
    
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $username = $_POST['username'];
            $password = $_POST['password'];
    
            $user = User::findByUsername($username);
    
            if ($user) {
                if ($password === $user['password']) {
                    $_SESSION['user'] = $user;
                    header('Location: index.php?action=goToHome');
                    exit();
                } else {
                    echo "Identifiants incorrects";
                }
            } else {
                echo "Identifiants incorrects";
            }
        }
        include __DIR__ . '/../views/pages/LoginView.php';
    }
    
    // Déconnexion
    public function logout() {
        $_SESSION = array();
        
        if (isset($_COOKIE[session_name()])) {
            setcookie(session_name(), '', time()-3600, '/');
        }
        
        session_destroy();
        
        header("Location: index.php?action=goToHome");
        exit();
    }

    // Afficher tous les utilisaterus
    public function listUsers() {
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
    
    
    

}
?>