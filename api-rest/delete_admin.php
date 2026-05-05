<?php
header('Content-Type: application/json');
require_once('../includes/Admin.class.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'] ?? '';

    if ($id) {
        Admin::delete_admin($id);
    } else {
        http_response_code(400);
        echo json_encode(["error" => "Falta el id"]);
    }
} else {
    http_response_code(405);
    echo json_encode(["error" => "Metodo no permitido"]);
}
?>