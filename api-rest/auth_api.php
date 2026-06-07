<?php
// auth_api.php — Autenticación de la API REST.
// Se incluye al principio de cada endpoint. Si la API key no es
// válida o no se envía, corta la ejecución con un 401 en JSON.

require_once __DIR__ . '/../config/api.php';

function obtenerApiKey() {
    // La clave llega en la cabecera HTTP "X-API-Key"
    if (isset($_SERVER['HTTP_X_API_KEY'])) {
        return $_SERVER['HTTP_X_API_KEY'];
    }
    // Fallback por si el servidor no rellena $_SERVER
    if (function_exists('getallheaders')) {
        foreach (getallheaders() as $nombre => $valor) {
            if (strtolower($nombre) === 'x-api-key') {
                return $valor;
            }
        }
    }
    return '';
}

function verificarApiKey() {
    $clave_recibida = obtenerApiKey();

    if ($clave_recibida === '' || !hash_equals(API_KEY, $clave_recibida)) {
        http_response_code(401);
        header('Content-Type: application/json');
        echo json_encode(["error" => "No autorizado. API key no valida o ausente."]);
        exit();
    }
}
?>