<?php
session_start();
require_once '../includes/Postulacion.class.php';

// Solo empresas
if (!isset($_SESSION['id']) || $_SESSION['rol'] != 'empresa') {
    header('Location: ../login.php');
    exit();
}

if (isset($_GET['id']) && isset($_GET['cv'])) {
    $id_postulacion = $_GET['id'];
    $cv = $_GET['cv'];

    // Cambiar a 'revisado' solo si esta en 'pendiente' (no pisar aceptado/rechazado)
    Postulacion::marcarRevisado($id_postulacion);

    // Redirigir al PDF
    header('Location: ../uploads/cv/' . $cv);
    exit();
}

header('Location: mis_ofertas.php');
exit();
?>