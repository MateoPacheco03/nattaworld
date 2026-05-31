<?php
session_start();
require_once '../includes/Oferta.class.php';

// Solo empresas
if (!isset($_SESSION['id']) || $_SESSION['rol'] != 'empresa') {
    header('Location: ../login.php');
    exit();
}

if (isset($_GET['id'])) {
    Oferta::eliminar($_GET['id']);
}

header('Location: mis_ofertas.php?mensaje=oferta_eliminada');
exit();
?>