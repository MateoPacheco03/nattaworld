<?php
class Database {
    private $host = "localhost";
    private $user = "root";
    private $password = "";
    private $name_database = "nattaworld";

    public function obtenerConexion() {
        try {
            $connection = new PDO(
                "mysql:host=" . $this->host . ";dbname=" . $this->name_database . ";charset=utf8mb4",
                $this->user,
                $this->password
            );
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $connection;
        } catch (PDOException $e) {
            die("ERROR: " . $e->getMessage());
        }
    }
}
?>