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
    
            if ($user) {
                if ($password === $user['password']) {
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
    
    
    

}
?>
