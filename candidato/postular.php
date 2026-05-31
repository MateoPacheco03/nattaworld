<?php
session_start();
require_once '../includes/Postulacion.class.php';

// Solo candidatos logueados pueden postularse
if (!isset($_SESSION['id']) || $_SESSION['rol'] != 'candidato') {
    header('Location: ../login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id_oferta'])) {
    $id_usuario = $_SESSION['id'];
    $id_oferta = $_POST['id_oferta'];

    // Evitar postulaciones duplicadas
    if (Postulacion::yaPostulado($id_usuario, $id_oferta)) {
        header('Location: ofertas.php?mensaje=ya_postulado');
        exit();
    }

    if (Postulacion::crear($id_usuario, $id_oferta)) {
        header('Location: ofertas.php?mensaje=postulado');
        exit();
    } else {
        header('Location: ofertas.php?mensaje=error');
        exit();
    }
}

header('Location: ofertas.php');
exit();
?>