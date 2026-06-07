<?php
header('Content-Type: application/json');
require_once('auth_api.php');
verificarApiKey();
require_once('../includes/Admin.class.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'] ?? '';
    $nombre = $_POST['nombre'] ?? '';
    $apellido1 = $_POST['apellido1'] ?? '';
    $apellido2 = $_POST['apellido2'] ?? '';
    $correo = $_POST['correo'] ?? '';
    $contrasena = $_POST['contrasena'] ?? '';

    if ($id && $nombre && $apellido1 && $correo) {
        Admin::update_admin($id, $nombre, $apellido1, $apellido2, $correo, $contrasena);
    } else {
        http_response_code(400);
        echo json_encode(["error" => "Faltan datos obligatorios"]);
    }
} else {
    http_response_code(405);
    echo json_encode(["error" => "Metodo no permitido"]);
}
?>