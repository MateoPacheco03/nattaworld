<?php
session_start();
require_once '../includes/Postulacion.class.php';

// Solo candidatos
if (!isset($_SESSION['id']) || $_SESSION['rol'] != 'candidato') {
    header('Location: ../login.php');
    exit();
}

if (isset($_GET['id'])) {
    Postulacion::cancelar($_GET['id'], $_SESSION['id']);
}

header('Location: mis_postulaciones.php?mensaje=cancelada');
exit();
?>