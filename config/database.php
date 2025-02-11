<?php
try {
    // Paramètres de connexion
    $host = '127.0.0.1';
    $dbname = 'CMS_projet';
    $username = 'root';
    $password = '';

    // Initialisation de la connexion PDO
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);

    // Configuration des options PDO
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

    // Vérification de la connexion
    echo "Connexion réussie à la base de données.";  // Affiche un message de succès

} catch (PDOException $e) {
    // Gestion des erreurs
    echo "Erreur de connexion : " . $e->getMessage();
    exit; // Arrête l'exécution du script en cas d'erreur critique
}
?>
