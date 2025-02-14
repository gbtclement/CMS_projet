<?php
class Database {
    private static $instance = null; 

    public static function getConnection() {
        if (self::$instance === null) {
            try {
                $host = '127.0.0.1';
                $dbname = 'CMS_projet';
                $username = 'root';
                $password = '';

                self::$instance = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
                self::$instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                self::$instance->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

            } catch (PDOException $e) {
                die("Erreur de connexion : " . $e->getMessage());
            }
        }
        return self::$instance;
    }
}
?>