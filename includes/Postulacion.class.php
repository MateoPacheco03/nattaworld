<?php
require_once('Database.class.php');

class Postulacion {

    public static function crear($id_usuario, $id_oferta) {
        $database = new Database();
        $conn = $database->obtenerConexion();
        try {
            $stmt = $conn->prepare('INSERT INTO POSTULACION (id_usuario, id_oferta, fecha_post, estado) VALUES (:id_usuario, :id_oferta, CURDATE(), :estado)');
            $estado = 'pendiente';
            $stmt->bindParam(':id_usuario', $id_usuario);
            $stmt->bindParam(':id_oferta', $id_oferta);
            $stmt->bindParam(':estado', $estado);
            return $stmt->execute();
        } catch (PDOException $e) {
            return false;
        }
    }

    public static function yaPostulado($id_usuario, $id_oferta) {
        $database = new Database();
        $conn = $database->obtenerConexion();
        $stmt = $conn->prepare('SELECT id FROM POSTULACION WHERE id_usuario = :id_usuario AND id_oferta = :id_oferta LIMIT 1');
        $stmt->bindParam(':id_usuario', $id_usuario);
        $stmt->bindParam(':id_oferta', $id_oferta);
        $stmt->execute();
        return $stmt->rowCount() > 0;
    }

    public static function listarPorUsuario($id_usuario) {
        $database = new Database();
        $conn = $database->obtenerConexion();
        $stmt = $conn->prepare('SELECT P.*, O.titulo, E.nombre AS empresa FROM POSTULACION P JOIN OFERTA O ON P.id_oferta = O.id JOIN EMPRESA E ON O.id_empresa = E.id WHERE P.id_usuario = :id_usuario ORDER BY P.fecha_post DESC');
        $stmt->bindParam(':id_usuario', $id_usuario);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public static function cancelar($id_postulacion, $id_usuario) {
    $database = new Database();
    $conn = $database->obtenerConexion();
    $stmt = $conn->prepare('DELETE FROM POSTULACION WHERE id = :id AND id_usuario = :id_usuario');
    $stmt->bindParam(':id', $id_postulacion);
    $stmt->bindParam(':id_usuario', $id_usuario);
    $stmt->execute();
    return $stmt->rowCount() > 0;
    }
    public static function contarPorUsuario($id_usuario) {
    $database = new Database();
    $conn = $database->obtenerConexion();
    $stmt = $conn->prepare('SELECT COUNT(*) AS total FROM POSTULACION WHERE id_usuario = :id_usuario');
    $stmt->bindParam(':id_usuario', $id_usuario);
    $stmt->execute();
    $fila = $stmt->fetch(PDO::FETCH_ASSOC);
    return $fila['total'];
    }
    public static function contarPorEmpresa($id_empresa) {
    $database = new Database();
    $conn = $database->obtenerConexion();
    $stmt = $conn->prepare('SELECT COUNT(*) AS total FROM POSTULACION P JOIN OFERTA O ON P.id_oferta = O.id WHERE O.id_empresa = :id_empresa');
    $stmt->bindParam(':id_empresa', $id_empresa);
    $stmt->execute();
    $fila = $stmt->fetch(PDO::FETCH_ASSOC);
    return $fila['total'];
}

    public static function contarAceptadosPorEmpresa($id_empresa) {
    $database = new Database();
    $conn = $database->obtenerConexion();
    $stmt = $conn->prepare("SELECT COUNT(*) AS total FROM POSTULACION P JOIN OFERTA O ON P.id_oferta = O.id WHERE O.id_empresa = :id_empresa AND P.estado = 'aceptado'");
    $stmt->bindParam(':id_empresa', $id_empresa);
    $stmt->execute();
    $fila = $stmt->fetch(PDO::FETCH_ASSOC);
    return $fila['total'];
    }

    public static function listarPorOferta($id_oferta) {
    $database = new Database();
    $conn = $database->obtenerConexion();
    $stmt = $conn->prepare('SELECT P.id, P.fecha_post, P.estado, U.nombre, U.apellido1, U.apellido2, U.correo, U.telefono FROM POSTULACION P JOIN USUARIO U ON P.id_usuario = U.id WHERE P.id_oferta = :id_oferta ORDER BY P.fecha_post DESC');
    $stmt->bindParam(':id_oferta', $id_oferta);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

public static function cambiarEstado($id_postulacion, $estado) {
    $database = new Database();
    $conn = $database->obtenerConexion();
    // Solo permitir estados validos
    if (!in_array($estado, ['pendiente', 'aceptado', 'rechazado'])) {
        return false;
    }
    $stmt = $conn->prepare('UPDATE POSTULACION SET estado = :estado WHERE id = :id');
    $stmt->bindParam(':estado', $estado);
    $stmt->bindParam(':id', $id_postulacion);
    $stmt->execute();
    return $stmt->rowCount() > 0;
}
}
?>