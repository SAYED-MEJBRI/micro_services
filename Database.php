<?php 
require_once 'config/db_config.php';

class Database {

    private $pdo;
    public function __construct() {
        $this -> connect();
    }
    private function connect()  {
        try {
            $this->pdo = new PDO("mysql:host=".DB_HOST.";dbname=".DB_DATABASE.";charset=utf8",DB_USER,DB_PASS);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            throw new Exception("Erreur de connexion à la base de données: ". $e->getMessage());
        }
    }
    public function getPDO() {
        return $this->pdo;
    }
}
