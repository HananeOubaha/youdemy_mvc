<?php
class Database {
    private static $instance = null;
    private $pdo;

    // Constructeur privé pour empêcher l'instanciation directe
    private function __construct() {
        $host = "localhost";
        $port = "5432";
        $db_name = "youdemy";
        $username = "postgres";
        $password = "Hanane@2002"; 

        try {
            $this->pdo = new PDO(
                "pgsql:host=$host;port=$port;dbname=$db_name",
                $username,
                $password,
                [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
            );
            error_log("Connection to PostgreSQL database established.");
        } catch (Exception $e) {
            error_log("Database connection error: " . $e->getMessage());
            throw new Exception("Database connection failed.");
        }
    }

    // Méthode statique pour obtenir l'instance unique
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    // Récupérer l'objet PDO
    public function getConnection() {
        return $this->pdo;
    }
}
?>