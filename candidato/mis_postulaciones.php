<?php
session_start();
require_once '../includes/Postulacion.class.php';

// Solo candidatos
if (!isset($_SESSION['id']) || $_SESSION['rol'] != 'candidato') {
    header('Location: ../login.php');
    exit();
}

$postulaciones = Postulacion::listarPorUsuario($_SESSION['id']);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nattaworld — Mis postulaciones</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/stylos.css">
    <link rel="stylesheet" href="../assets/css/botones.css">
</head>
<body>

    <?php include '../includes/navbar.php'; ?>

    <main>
        <div class="container mt-5">
            <h2 class="fw-bold mb-4">Mis postulaciones</h2>

            <?php if (isset($_GET['mensaje']) && $_GET['mensaje'] == 'cancelada'): ?>
                <div class="alert alert-info">Postulacion cancelada.</div>
            <?php endif; ?>
            <?php if (isset($_GET['mensaje']) && $_GET['mensaje'] == 'eliminada'): ?>
                <div class="alert alert-info">Postulacion eliminada.</div>
            <?php endif; ?>

            <?php if (count($postulaciones) == 0): ?>
                <div class="alert alert-info">Todavia no te has postulado a ninguna oferta. <a href="../ofertas.php">Ver ofertas disponibles</a></div>
            <?php else: ?>
                <div class="row g-4">
                    <?php foreach ($postulaciones as $p): ?>
                        <div class="col-md-6">
                            <div class="card shadow-sm h-100">
                                <div class="card-body p-4">
                                    <small class="text-muted"><?php echo htmlspecialchars($p['empresa']); ?></small>
                                    <h5 class="fw-bold"><?php echo htmlspecialchars($p['titulo']); ?></h5>
                                    <p class="text-muted mb-2" style="font-size:14px;">Postulado el: <?php echo $p['fecha_post']; ?></p>
                                    <?php
                                        $estado = $p['estado'];
                                        $color = 'secondary';
                                        if ($estado == 'pendiente') $color = 'warning';
                                        if ($estado == 'revisado') $color = 'info';
                                        if ($estado == 'aceptado') $color = 'success';
                                        if ($estado == 'rechazado') $color = 'danger';
                                    ?>
                                    <span class="badge bg-<?php echo $color; ?>"><?php echo ucfirst($estado); ?></span>
                                    <div class="mt-3">
                                        <?php if ($p['estado'] == 'rechazado'): ?>
                                            <a href="cancelar_postulacion.php?id=<?php echo $p['id']; ?>" class="btn btn-outline-danger btn-sm" onclick="return confirm('Seguro que quieres eliminar esta postulacion?')">Eliminar postulacion</a>
                                        <?php else: ?>
                                            <a href="cancelar_postulacion.php?id=<?php echo $p['id']; ?>" class="btn btn-outline-danger btn-sm" onclick="return confirm('Seguro que quieres cancelar esta postulacion?')">Cancelar postulacion</a>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </main>

    <?php include '../includes/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>