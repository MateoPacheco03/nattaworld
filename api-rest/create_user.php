<?php
header('Content-Type: application/json');
require_once('../includes/User.class.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'] ?? '';
    $apellido1 = $_POST['apellido1'] ?? '';
    $apellido2 = $_POST['apellido2'] ?? '';
    $correo = $_POST['correo'] ?? '';
    $contrasena = $_POST['contrasena'] ?? '';
    $telefono = $_POST['telefono'] ?? '';

    if ($nombre && $apellido1 && $correo && $contrasena) {
        User::create_user($nombre, $apellido1, $apellido2, $correo, $contrasena, $telefono);
    } else {
        http_response_code(400);
        echo json_encode(["error" => "Faltan datos obligatorios"]);
    }
} else {
    http_response_code(405);
    echo json_encode(["error" => "Metodo no permitido"]);
}
?>