<?php
session_start();
require_once '../includes/Postulacion.class.php';
require_once '../includes/Oferta.class.php';

// Solo candidatos
if (!isset($_SESSION['id']) || $_SESSION['rol'] != 'candidato') {
    header('Location: ../login.php');
    exit();
}

$total_postulaciones = Postulacion::contarPorUsuario($_SESSION['id']);
$total_ofertas = Oferta::contarTodas();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NattaWorld — Mi panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/stylos.css">
    <link rel="stylesheet" href="../assets/css/botones.css">
</head>
<body>

    <?php include '../includes/navbar.php'; ?>

    <main>
        <div class="container mt-5">
            <h2 class="fw-bold">Hola, <?php echo htmlspecialchars($_SESSION['nombre']); ?> 👋</h2>
            <p class="text-muted">Bienvenido a tu panel de candidato.</p>

            <?php if (isset($_GET['mensaje']) && $_GET['mensaje'] == 'perfil_actualizado'): ?>
            <div class="alert alert-success">Perfil actualizado correctamente.</div>
            <?php endif; ?>

            <!-- Estadisticas -->
            <div class="row g-4 mt-2">
                <div class="col-md-4">
                    <div class="card shadow-sm">
                        <div class="card-body text-center p-4">
                            <div class="display-5 fw-bold text-primary"><?php echo $total_ofertas; ?></div>
                            <small class="text-muted">Ofertas disponibles</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card shadow-sm">
                        <div class="card-body text-center p-4">
                            <div class="display-5 fw-bold text-success"><?php echo $total_postulaciones; ?></div>
                            <small class="text-muted">Mis postulaciones</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card shadow-sm">
                        <div class="card-body text-center p-4">
                            <div class="display-5 fw-bold">👤</div>
                            <small class="text-muted">Perfil de candidato</small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Accesos -->
            <div class="row g-4 mt-2">
                <div class="col-md-4">
                    <div class="card shadow-sm h-100">
                        <div class="card-body p-4 text-center">
                            <h5 class="fw-bold">Ofertas disponibles</h5>
                            <p class="text-muted">Explora las ofertas y postulate a las que encajen contigo.</p>
                            <a href="../ofertas.php" class="btn btn-success">Ver ofertas</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card shadow-sm h-100">
                        <div class="card-body p-4 text-center">
                            <h5 class="fw-bold">Mis postulaciones</h5>
                            <p class="text-muted">Consulta el estado de las ofertas a las que te has postulado.</p>
                            <a href="mis_postulaciones.php" class="btn btn-outline-primary">Ver postulaciones</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card shadow-sm h-100">
                        <div class="card-body p-4 text-center">
                            <h5 class="fw-bold">Mi perfil</h5>
                            <p class="text-muted">Edita tus datos personales y mantenlos actualizados.</p>
                            <a href="editar_perfil.php" class="btn btn-outline-secondary">Editar perfil</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <?php include '../includes/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>