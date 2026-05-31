<?php
require_once('Database.class.php');

class Estadisticas {

    private static function contar($tabla) {
        $database = new Database();
        $conn = $database->obtenerConexion();
        $stmt = $conn->prepare("SELECT COUNT(*) AS total FROM $tabla");
        $stmt->execute();
        $fila = $stmt->fetch(PDO::FETCH_ASSOC);
        return $fila['total'];
    }

    public static function totalUsuarios() {
        return self::contar('USUARIO');
    }

    public static function totalEmpresas() {
        return self::contar('EMPRESA');
    }

    public static function totalOfertas() {
        return self::contar('OFERTA');
    }

    public static function totalPostulaciones() {
        return self::contar('POSTULACION');
    }
}
?>