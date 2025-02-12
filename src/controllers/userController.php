<?php
require_once __DIR__ . '/../models/User.php';


class UserController {

    // Connexion utilisateur
    public function login() {
        session_start();
    
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $username = $_POST['username'];
            $password = $_POST['password'];
    
            $user = User::findByUsername($username);
    
            if ($user) {
                if ($password === $user['password']) {
                    $_SESSION['user'] = $user;
                    header('Location: ../admin/Dashboard.php');
                    exit();
                } else {
                    echo "Identifiants incorrects";
                }
            } else {
                echo "Identifiants incorrects";
            }
        }
    }
    
    // Déconnexion utilisateur
    public function logout() {
        session_start();
        session_destroy();
        header("Location: /index.php");
        exit();
    }

    // Afficher tous les utilisateurs
    public function listUsers() {
        // Vérifier si la session n'est pas déjà démarrée
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    
        if (!isset($_SESSION['user'])) {
            echo "Accès refusé : vous devez être connecté.";
            exit();
        }
    
        if ($_SESSION['user']['role'] !== 'admin') {
            echo "Accès refusé : vous n'avez pas les permissions nécessaires.";
            exit();
        }
    
        $users = User::getAll();
        
        return $users;
    }
    
    
    

}
?>
