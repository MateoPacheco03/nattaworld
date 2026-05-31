<?php
require_once('Database.class.php');

class Empresa {

    public static function registrar($nif, $nombre, $correo, $contrasena, $telefono) {
        $database = new Database();
        $conn = $database->obtenerConexion();
        $contrasena_cifrada = password_hash($contrasena, PASSWORD_BCRYPT);
        try {
            $stmt = $conn->prepare('INSERT INTO EMPRESA (nif, nombre, correo, contrasena, telefono) VALUES (:nif, :nombre, :correo, :contrasena, :telefono)');
            $stmt->bindParam(':nif', $nif);
            $stmt->bindParam(':nombre', $nombre);
            $stmt->bindParam(':correo', $correo);
            $stmt->bindParam(':contrasena', $contrasena_cifrada);
            $stmt->bindParam(':telefono', $telefono);
            return $stmt->execute();
        } catch (PDOException $e) {
            return false;
        }
    }

    public static function correoExiste($correo) {
        $database = new Database();
        $conn = $database->obtenerConexion();
        $stmt = $conn->prepare('SELECT id FROM EMPRESA WHERE correo = :correo LIMIT 1');
        $stmt->bindParam(':correo', $correo);
        $stmt->execute();
        return $stmt->rowCount() > 0;
    }
}
?>