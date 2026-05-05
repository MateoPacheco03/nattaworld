<?php
require_once('Database.class.php');

class Admin {

    public static function create_admin($nombre, $apellido1, $apellido2, $correo, $contrasena) {
        $database = new Database();
        $conn = $database->obtenerConexion();
        $contrasena_cifrada = password_hash($contrasena, PASSWORD_BCRYPT);
        $stmt = $conn->prepare('INSERT INTO ADMINISTRADOR (nombre, apellido1, apellido2, correo, contrasena) VALUES (:nombre, :apellido1, :apellido2, :correo, :contrasena)');
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':apellido1', $apellido1);
        $stmt->bindParam(':apellido2', $apellido2);
        $stmt->bindParam(':correo', $correo);
        $stmt->bindParam(':contrasena', $contrasena_cifrada);
        if ($stmt->execute()) {
            http_response_code(201);
            echo json_encode(["mensaje" => "Administrador creado correctamente"]);
        } else {
            http_response_code(500);
            echo json_encode(["error" => "No se ha podido crear el administrador"]);
        }
    }

    public static function get_all_admins() {
        $database = new Database();
        $conn = $database->obtenerConexion();
        $stmt = $conn->prepare('SELECT id, nombre, apellido1, apellido2, correo FROM ADMINISTRADOR');
        if ($stmt->execute()) {
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            http_response_code(200);
            echo json_encode($result);
        } else {
            http_response_code(500);
            echo json_encode(["error" => "No se ha podido consultar los administradores"]);
        }
    }

    public static function update_admin($id, $nombre, $apellido1, $apellido2, $correo, $contrasena) {
    $database = new Database();
    $conn = $database->obtenerConexion();
    try {
        if ($contrasena) {
            $contrasena_cifrada = password_hash($contrasena, PASSWORD_BCRYPT);
            $stmt = $conn->prepare('UPDATE ADMINISTRADOR SET nombre = :nombre, apellido1 = :apellido1, apellido2 = :apellido2, correo = :correo, contrasena = :contrasena WHERE id = :id');
            $stmt->bindParam(':contrasena', $contrasena_cifrada);
        } else {
            $stmt = $conn->prepare('UPDATE ADMINISTRADOR SET nombre = :nombre, apellido1 = :apellido1, apellido2 = :apellido2, correo = :correo WHERE id = :id');
        }
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':apellido1', $apellido1);
        $stmt->bindParam(':apellido2', $apellido2);
        $stmt->bindParam(':correo', $correo);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            http_response_code(200);
            echo json_encode(["mensaje" => "Administrador actualizado correctamente"]);
        } else {
            http_response_code(404);
            echo json_encode(["error" => "Administrador no encontrado"]);
        }
    } catch (PDOException $e) {
        http_response_code(400);
        echo json_encode(["error" => "El correo ya esta registrado"]);
    }
}

    public static function delete_admin($id) {
        $database = new Database();
        $conn = $database->obtenerConexion();
        $stmt = $conn->prepare('DELETE FROM ADMINISTRADOR WHERE id = :id');
        $stmt->bindParam(':id', $id);
        if ($stmt->execute()) {
            http_response_code(200);
            echo json_encode(["mensaje" => "Administrador borrado correctamente"]);
        } else {
            http_response_code(500);
            echo json_encode(["error" => "No se ha podido borrar el administrador"]);
        }
    }
}
?>