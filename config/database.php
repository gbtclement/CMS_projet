<?php 
$host = "localhost"; 
$dbname = "mon_cms"; 
$username = "root"; 
$password = ""; 
try { 
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password); 
    $pdo-, PDO::ERRMODE_EXCEPTION); 
} catch (PDOException $e) { 
    die("Erreur de connexion : " . $e-
} 
?> 
