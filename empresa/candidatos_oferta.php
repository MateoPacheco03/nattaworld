<?php
session_start();
require_once '../includes/Postulacion.class.php';
require_once '../includes/Oferta.class.php';

// Solo empresas
if (!isset($_SESSION['id']) || $_SESSION['rol'] != 'empresa') {
    header('Location: ../login.php');
    exit();
}

if (!isset($_GET['id'])) {
    header('Location: mis_ofertas.php');
    exit();
}

$id_oferta = $_GET['id'];
if (!Oferta::perteneceA($id_oferta, $_SESSION['id'])) {
        header('Location: mis_ofertas.php');
        exit();
}
$oferta = Oferta::obtener($id_oferta);
$candidatos = Postulacion::listarPorOferta($id_oferta);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nattaworld — Candidatos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/stylos.css">
    <link rel="stylesheet" href="../assets/css/botones.css">
    <link rel="icon" type="image/png" sizes="32x32" href="/juniorworld/assets/img/iconos/iconoNattaworld.png">
</head>
<body>

    <?php include '../includes/navbar.php'; ?>

    <main>
        <div class="container mt-5">
            <a href="mis_ofertas.php" class="text-muted" style="text-decoration:none;">← Volver a mis ofertas</a>
            <h2 class="fw-bold mt-2 mb-1">Candidatos recibidos</h2>
            <p class="text-muted">Oferta: <strong><?php echo htmlspecialchars($oferta['titulo']); ?></strong></p>

            <?php if (count($candidatos) == 0): ?>
                <div class="alert alert-info">Todavia no hay candidatos para esta oferta.</div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-striped align-middle">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Correo</th>
                                <th>Telefono</th>
                                <th>Fecha</th>
                                <th>Estado</th>
                                <th>CV</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($candidatos as $c): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($c['nombre'] . ' ' . $c['apellido1'] . ' ' . $c['apellido2']); ?></td>
                                    <td><?php echo htmlspecialchars($c['correo']); ?></td>
                                    <td><?php echo htmlspecialchars($c['telefono']); ?></td>
                                    <td><?php echo $c['fecha_post']; ?></td>
                                    <td>
                                        <?php
                                            $estado = $c['estado'];
                                            $color = 'secondary';
                                            if ($estado == 'pendiente') $color = 'warning';
                                            if ($estado == 'revisado') $color = 'info';
                                            if ($estado == 'aceptado') $color = 'success';
                                            if ($estado == 'rechazado') $color = 'danger';
                                        ?>
                                        <span class="badge bg-<?php echo $color; ?>"><?php echo ucfirst($estado); ?></span>
                                    </td>
                                    <td>
                                        <?php if (!empty($c['cv'])): ?>
                                            <a href="ver_cv.php?id=<?php echo $c['id']; ?>" class="btn btn-outline-primary btn-sm" target="_blank">Ver CV</a>
                                        <?php else: ?>
                                            <span class="text-muted">No disponible</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <a href="gestionar_candidato.php?id=<?php echo $c['id']; ?>&estado=aceptado&oferta=<?php echo $id_oferta; ?>" class="btn btn-success btn-sm">Aceptar</a>
                                        <a href="gestionar_candidato.php?id=<?php echo $c['id']; ?>&estado=rechazado&oferta=<?php echo $id_oferta; ?>" class="btn btn-outline-danger btn-sm">Rechazar</a>
                                    </td>
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