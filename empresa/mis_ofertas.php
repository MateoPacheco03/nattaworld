<?php
session_start();
require_once '../includes/Oferta.class.php';

// Solo empresas
if (!isset($_SESSION['id']) || $_SESSION['rol'] != 'empresa') {
    header('Location: ../login.php');
    exit();
}

$ofertas = Oferta::listarPorEmpresa($_SESSION['id']);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NattaWorld — Mis ofertas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/stylos.css">
    <link rel="stylesheet" href="../assets/css/botones.css">
</head>
<body>

    <?php include '../includes/navbar.php'; ?>

    <main>
        <div class="container mt-5">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="fw-bold">Mis ofertas publicadas</h2>
                <a href="crear_oferta.php" class="btn btn-success">+ Publicar oferta</a>
            </div>

            <?php if (isset($_GET['mensaje']) && $_GET['mensaje'] == 'oferta_creada'): ?>
                <div class="alert alert-success">Oferta publicada correctamente.</div>
            <?php endif; ?>
            <?php if (isset($_GET['mensaje']) && $_GET['mensaje'] == 'oferta_actualizada'): ?>
                <div class="alert alert-success">Oferta actualizada correctamente.</div>
            <?php endif; ?>
            <?php if (isset($_GET['mensaje']) && $_GET['mensaje'] == 'oferta_eliminada'): ?>
                <div class="alert alert-info">Oferta eliminada.</div>
            <?php endif; ?>

            <?php if (count($ofertas) == 0): ?>
                <div class="alert alert-info">Todavia no has publicado ninguna oferta.</div>
            <?php else: ?>
                <div class="row g-4">
                    <?php foreach ($ofertas as $o): ?>
                        <div class="col-md-6">
                            <div class="card shadow-sm h-100">
                                <div class="card-body p-4">
                                    <h5 class="fw-bold"><?php echo htmlspecialchars($o['titulo']); ?></h5>
                                    <div class="mb-2">
                                        <span class="badge bg-light text-dark">📍 <?php echo htmlspecialchars($o['ubicacion']); ?></span>
                                        <span class="badge bg-light text-dark"><?php echo htmlspecialchars($o['area']); ?></span>
                                    </div>
                                    <small class="text-muted">Publicada: <?php echo $o['fecha']; ?></small>
                                    <p class="text-muted mt-2" style="font-size:14px;"><?php echo nl2br(htmlspecialchars($o['descripcion'])); ?></p>
                                    <a href="candidatos_oferta.php?id=<?php echo $o['id']; ?>" class="btn btn-outline-success btn-sm">Ver candidatos</a>
                                    <a href="editar_oferta.php?id=<?php echo $o['id']; ?>" class="btn btn-outline-primary btn-sm">Editar</a>
                                    <a href="eliminar_oferta.php?id=<?php echo $o['id']; ?>" class="btn btn-outline-danger btn-sm" onclick="return confirm('Seguro que quieres eliminar esta oferta?')">Eliminar</a>
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