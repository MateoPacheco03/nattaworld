<?php
require_once('Database.class.php');

class User {

    public static function create_user($nombre, $apellido1, $apellido2, $correo, $contrasena, $telefono) {
    $database = new Database();
    $conn = $database->obtenerConexion();
    $contrasena_cifrada = password_hash($contrasena, PASSWORD_BCRYPT);
    $stmt = $conn->prepare('INSERT INTO USUARIO (nombre, apellido1, apellido2, correo, contrasena, telefono) VALUES (:nombre, :apellido1, :apellido2, :correo, :contrasena, :telefono)');
    $stmt->bindParam(':nombre', $nombre);
    $stmt->bindParam(':apellido1', $apellido1);
    $stmt->bindParam(':apellido2', $apellido2);
    $stmt->bindParam(':correo', $correo);
    $stmt->bindParam(':contrasena', $contrasena_cifrada);
    $stmt->bindParam(':telefono', $telefono);
    if ($stmt->execute()) {
        http_response_code(201);
        echo json_encode(["mensaje" => "Usuario creado correctamente"]);
    } else {
        http_response_code(500);
        echo json_encode(["error" => "No se ha podido crear el usuario"]);
        }
    }

    public static function delete_user_by_id($id) {
    $database = new Database();
    $conn = $database->obtenerConexion();
    $stmt = $conn->prepare('DELETE FROM USUARIO WHERE id = :id');
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    if ($stmt->rowCount() > 0) {
        http_response_code(200);
        echo json_encode(["mensaje" => "Usuario borrado correctamente"]);
    } else {
        http_response_code(404);
        echo json_encode(["error" => "Usuario no encontrado"]);
        }
    }

    public static function get_all_users() {
        $database = new Database();
        $conn = $database->obtenerConexion();
        $stmt = $conn->prepare('SELECT id, nombre, apellido1, apellido2, correo, telefono FROM USUARIO');
        if ($stmt->execute()) {
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            http_response_code(200);
            echo json_encode($result);
        } else {
            http_response_code(500);
            echo json_encode(["error" => "No se ha podido consultar los usuarios"]);
        }
    }

    public static function update_user($id, $nombre, $apellido1, $apellido2, $correo, $contrasena) {
    $database = new Database();
    $conn = $database->obtenerConexion();
    if ($contrasena) {
        $contrasena_cifrada = password_hash($contrasena, PASSWORD_BCRYPT);
        $stmt = $conn->prepare('UPDATE USUARIO SET nombre = :nombre, apellido1 = :apellido1, apellido2 = :apellido2, correo = :correo, contrasena = :contrasena WHERE id = :id');
        $stmt->bindParam(':contrasena', $contrasena_cifrada);
    } else {
        $stmt = $conn->prepare('UPDATE USUARIO SET nombre = :nombre, apellido1 = :apellido1, apellido2 = :apellido2, correo = :correo WHERE id = :id');
    }
    $stmt->bindParam(':nombre', $nombre);
    $stmt->bindParam(':apellido1', $apellido1);
    $stmt->bindParam(':apellido2', $apellido2);
    $stmt->bindParam(':correo', $correo);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    if ($stmt->rowCount() > 0) {
        http_response_code(200);
        echo json_encode(["mensaje" => "Usuario actualizado correctamente"]);
    } else {
        http_response_code(404);
        echo json_encode(["error" => "Usuario no encontrado"]);
        }
    }
}
?>