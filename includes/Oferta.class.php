<?php
require_once('Database.class.php');

class Oferta {

    public static function crear($id_empresa, $titulo, $descripcion, $ubicacion, $area) {
        $database = new Database();
        $conn = $database->obtenerConexion();
        try {
            $stmt = $conn->prepare('INSERT INTO OFERTA (id_empresa, titulo, descripcion, ubicacion, area, fecha) VALUES (:id_empresa, :titulo, :descripcion, :ubicacion, :area, CURDATE())');
            $stmt->bindParam(':id_empresa', $id_empresa);
            $stmt->bindParam(':titulo', $titulo);
            $stmt->bindParam(':descripcion', $descripcion);
            $stmt->bindParam(':ubicacion', $ubicacion);
            $stmt->bindParam(':area', $area);
            return $stmt->execute();
        } catch (PDOException $e) {
            return false;
        }
    }

    public static function listarPorEmpresa($id_empresa) {
        $database = new Database();
        $conn = $database->obtenerConexion();
        $stmt = $conn->prepare('SELECT * FROM OFERTA WHERE id_empresa = :id_empresa ORDER BY fecha DESC');
        $stmt->bindParam(':id_empresa', $id_empresa);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function listarTodas() {
        $database = new Database();
        $conn = $database->obtenerConexion();
        $stmt = $conn->prepare('SELECT O.*, E.nombre AS empresa FROM OFERTA O JOIN EMPRESA E ON O.id_empresa = E.id ORDER BY O.fecha DESC');
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function obtener($id) {
        $database = new Database();
        $conn = $database->obtenerConexion();
        $stmt = $conn->prepare('SELECT O.*, E.nombre AS empresa FROM OFERTA O JOIN EMPRESA E ON O.id_empresa = E.id WHERE O.id = :id LIMIT 1');
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function eliminar($id) {
        $database = new Database();
        $conn = $database->obtenerConexion();
        $stmt = $conn->prepare('DELETE FROM OFERTA WHERE id = :id');
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->rowCount() > 0;
    }

    public static function actualizar($id, $titulo, $descripcion, $ubicacion, $area) {
    $database = new Database();
    $conn = $database->obtenerConexion();
    try {
        $stmt = $conn->prepare('UPDATE OFERTA SET titulo = :titulo, descripcion = :descripcion, ubicacion = :ubicacion, area = :area WHERE id = :id');
        $stmt->bindParam(':titulo', $titulo);
        $stmt->bindParam(':descripcion', $descripcion);
        $stmt->bindParam(':ubicacion', $ubicacion);
        $stmt->bindParam(':area', $area);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->rowCount() >= 0;
    } catch (PDOException $e) {
        return false;
        }
    }
    public static function contarTodas() {
    $database = new Database();
    $conn = $database->obtenerConexion();
    $stmt = $conn->prepare('SELECT COUNT(*) AS total FROM OFERTA');
    $stmt->execute();
    $fila = $stmt->fetch(PDO::FETCH_ASSOC);
    return $fila['total'];
    }
    public static function contarPorEmpresa($id_empresa) {
    $database = new Database();
    $conn = $database->obtenerConexion();
    $stmt = $conn->prepare('SELECT COUNT(*) AS total FROM OFERTA WHERE id_empresa = :id_empresa');
    $stmt->bindParam(':id_empresa', $id_empresa);
    $stmt->execute();
    $fila = $stmt->fetch(PDO::FETCH_ASSOC);
    return $fila['total'];
    }
}
?>