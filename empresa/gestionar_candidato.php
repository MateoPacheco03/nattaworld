<?php
session_start();
require_once '../includes/Postulacion.class.php';

// Solo empresas
if (!isset($_SESSION['id']) || $_SESSION['rol'] != 'empresa') {
    header('Location: ../login.php');
    exit();
}

if (isset($_GET['id']) && isset($_GET['estado']) && isset($_GET['oferta'])) {
    Postulacion::cambiarEstado($_GET['id'], $_GET['estado']);
    header('Location: candidatos_oferta.php?id=' . $_GET['oferta']);
    exit();
}

header('Location: mis_ofertas.php');
exit();
?>