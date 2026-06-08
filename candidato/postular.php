<?php
session_start();
require_once '../includes/Postulacion.class.php';
require_once '../config/database.php';

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
        header('Location: ../ofertas.php?mensaje=ya_postulado');
        exit();
    }

    $cv_final = null;
    $opcion = isset($_POST['opcion_cv']) ? $_POST['opcion_cv'] : 'perfil';

    if ($opcion == 'perfil') {
        // Usar el CV del perfil del usuario
        $stmt = $conexion->prepare("SELECT cv FROM USUARIO WHERE id = :id LIMIT 1");
        $stmt->bindParam(':id', $id_usuario);
        $stmt->execute();
        $datos = $stmt->fetch(PDO::FETCH_ASSOC);
        $cv_final = $datos['cv'];

    } elseif ($opcion == 'nuevo') {
        // Subir un CV nuevo para esta postulacion
        if (isset($_FILES['cv_nuevo']) && $_FILES['cv_nuevo']['error'] == 0) {
            $tipo = $_FILES['cv_nuevo']['type'];
            $tamano = $_FILES['cv_nuevo']['size'];

            if ($tipo != 'application/pdf') {
                header('Location: oferta_detalle.php?id=' . $id_oferta . '&error=formato');
                exit();
            }
            if ($tamano > 2 * 1024 * 1024) {
                header('Location: oferta_detalle.php?id=' . $id_oferta . '&error=tamano');
                exit();
            }

            $cv_final = 'cv_' . $id_usuario . '_oferta' . $id_oferta . '_' . time() . '.pdf';
            $ruta_destino = $_SERVER['DOCUMENT_ROOT'] . '/nattaworld/uploads/cv/' . $cv_final;
            if (!move_uploaded_file($_FILES['cv_nuevo']['tmp_name'], $ruta_destino)) {
                header('Location: oferta_detalle.php?id=' . $id_oferta . '&error=subida');
                exit();
            }
        }
    }

    // Si no hay CV (ni del perfil ni nuevo), no permitir postularse
    if (empty($cv_final)) {
        header('Location: oferta_detalle.php?id=' . $id_oferta . '&error=sin_cv');
        exit();
    }

    if (Postulacion::crear($id_usuario, $id_oferta, $cv_final)) {
        header('Location: ../ofertas.php?mensaje=postulado');
        exit();
    } else {
        header('Location: ../ofertas.php?mensaje=error');
        exit();
    }
}

header('Location: ../ofertas.php');
exit();
?>