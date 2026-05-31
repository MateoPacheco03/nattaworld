<?php
session_start();
require_once '../includes/Oferta.class.php';
$ofertas = Oferta::listarTodas();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Natt World — Ofertas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/stylos.css">
    <link rel="stylesheet" href="../assets/css/botones.css">
</head>
<body>

    <?php include '../includes/navbar.php'; ?>

    <main>
        <div class="container mt-5">
            <h2 class="fw-bold mb-4">Ofertas disponibles</h2>

            <?php if (isset($_GET['mensaje']) && $_GET['mensaje'] == 'postulado'): ?>
                <div class="alert alert-success">Te has postulado correctamente.</div>
            <?php endif; ?>
            <?php if (isset($_GET['mensaje']) && $_GET['mensaje'] == 'ya_postulado'): ?>
                <div class="alert alert-warning">Ya te habias postulado a esta oferta.</div>
            <?php endif; ?>
            <?php if (isset($_GET['mensaje']) && $_GET['mensaje'] == 'error'): ?>
                <div class="alert alert-danger">Hubo un error al postularte. Intentalo de nuevo.</div>
            <?php endif; ?>

            <?php if (count($ofertas) == 0): ?>
                <div class="alert alert-info">No hay ofertas disponibles en este momento.</div>
            <?php else: ?>
                <div class="row g-4">
                    <?php foreach ($ofertas as $o): ?>
                        <div class="col-md-6">
                            <div class="card shadow-sm h-100">
                                <div class="card-body p-4">
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <div>
                                            <small class="text-muted"><?php echo htmlspecialchars($o['empresa']); ?></small>
                                            <h5 class="fw-bold mb-0"><?php echo htmlspecialchars($o['titulo']); ?></h5>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <span class="badge bg-light text-dark">📍 <?php echo htmlspecialchars($o['ubicacion']); ?></span>
                                        <span class="badge bg-light text-dark"><?php echo htmlspecialchars($o['area']); ?></span>
                                    </div>
                                    <p class="text-muted" style="font-size:14px;"><?php echo nl2br(htmlspecialchars($o['descripcion'])); ?></p>
                                    <?php if (isset($_SESSION['id']) && $_SESSION['rol'] == 'candidato'): ?>
                                        <form method="POST" action="postular.php">
                                            <input type="hidden" name="id_oferta" value="<?php echo $o['id']; ?>">
                                            <button type="submit" class="btn btn-success w-100">Postularme</button>
                                        </form>
                                    <?php else: ?>
                                        <a href="../login.php" class="btn btn-success w-100">Inicia sesion para postularte</a>
                                    <?php endif; ?>
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