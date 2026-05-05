<?php
header('Content-Type: application/json');
require_once('../includes/User.class.php');

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    User::get_all_users();
} else {
    http_response_code(405);
    echo json_encode(["error" => "Metodo no permitido"]);
}
?>