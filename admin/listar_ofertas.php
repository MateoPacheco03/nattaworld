<?php
session_start();
require_once '../includes/Oferta.class.php';

if (!isset($_SESSION['id']) || $_SESSION['rol'] != 'admin') {
    header('Location: ../login.php');
    exit();
}

$ofertas = Oferta::listarTodas();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NattaWorld — Ofertas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/stylos.css">
    <link rel="stylesheet" href="../assets/css/botones.css">
</head>
<body>

    <?php include '../includes/navbar.php'; ?>

    <main>
        <div class="container mt-5">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="fw-bold">Ofertas publicadas</h2>
                <a href="panel_admin.php" class="btn btn-outline-secondary">← Volver al panel</a>
            </div>

            <?php if (count($ofertas) == 0): ?>
                <div class="alert alert-info">No hay ofertas publicadas.</div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-striped table-bordered align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th>ID</th>
                                <th>Titulo</th>
                                <th>Empresa</th>
                                <th>Area</th>
                                <th>Ubicacion</th>
                                <th>Fecha</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($ofertas as $o): ?>
                                <tr>
                                    <td><?php echo $o['id']; ?></td>
                                    <td><?php echo htmlspecialchars($o['titulo']); ?></td>
                                    <td><?php echo htmlspecialchars($o['empresa']); ?></td>
                                    <td><?php echo htmlspecialchars($o['area']); ?></td>
                                    <td><?php echo htmlspecialchars($o['ubicacion']); ?></td>
                                    <td><?php echo $o['fecha']; ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </main>

    <?php include '../includes/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>