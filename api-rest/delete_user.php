<?php
header('Content-Type: application/json');
require_once('../includes/User.class.php');
require_once('auth_api.php');
verificarApiKey();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'] ?? '';

    if ($id) {
        User::delete_user_by_id($id);
    } else {
        http_response_code(400);
        echo json_encode(["error" => "Falta el id"]);
    }
} else {
    http_response_code(405);
    echo json_encode(["error" => "Metodo no permitido"]);
}
?>