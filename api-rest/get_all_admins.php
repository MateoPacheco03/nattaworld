<?php
header('Content-Type: application/json');
require_once('../includes/Admin.class.php');
require_once('auth_api.php');
verificarApiKey();

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    Admin::get_all_admins();
} else {
    http_response_code(405);
    echo json_encode(["error" => "Metodo no permitido"]);
}
?>