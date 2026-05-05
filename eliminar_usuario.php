<?php
session_start();
require_once 'config/database.php';

if (!isset($_SESSION['id']) || $_SESSION['rol'] != 'admin') {
    header('Location: login.php');
    exit();
}

$id = $_GET['id'];
$stmt = $conexion->prepare("DELETE FROM USUARIO WHERE id = :id");
$stmt->bindParam(':id', $id);

if ($stmt->execute()) {
    header('Location: listar_usuarios.php?mensaje=eliminado');
    exit();
} else {
    header('Location: listar_usuarios.php?mensaje=error');
    exit();
}
?>