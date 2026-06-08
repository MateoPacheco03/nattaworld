<?php
session_start();
require_once '../includes/Postulacion.class.php';

// Solo empresas
if (!isset($_SESSION['id']) || $_SESSION['rol'] != 'empresa') {
    header('Location: ../login.php');
    exit();
}

if (isset($_GET['id'])) {
    $id_postulacion = $_GET['id'];

    // Comprobar que la postulacion pertenece a una oferta de esta empresa
    if (!Postulacion::perteneceAEmpresa($id_postulacion, $_SESSION['id'])) {
        header('Location: mis_ofertas.php');
        exit();
    }

    // Obtener el nombre del CV desde la base de datos, NO desde la URL
    $datos = Postulacion::obtenerCv($id_postulacion);
    $cv = $datos['cv'] ?? '';

    // Sanear: nos quedamos solo con el nombre del archivo (evita ../)
    $cv = basename($cv);

    if ($cv === '') {
        header('Location: mis_ofertas.php');
        exit();
    }

    // Marcar como revisado solo si estaba pendiente
    Postulacion::marcarRevisado($id_postulacion);

    // Servir el PDF de forma controlada
    $ruta = $_SERVER['DOCUMENT_ROOT'] . '/nattaworld/uploads/cv/' . $cv;
    if (file_exists($ruta)) {
        header('Content-Type: application/pdf');
        header('Content-Disposition: inline; filename="' . $cv . '"');
        readfile($ruta);
        exit();
    }
}

header('Location: mis_ofertas.php');
exit();
?>