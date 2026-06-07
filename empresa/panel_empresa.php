<?php
session_start();
require_once '../includes/Oferta.class.php';
require_once '../includes/Postulacion.class.php';

// Solo empresas
if (!isset($_SESSION['id']) || $_SESSION['rol'] != 'empresa') {
    header('Location: ../login.php');
    exit();
}

$id_empresa = $_SESSION['id'];
$total_ofertas = Oferta::contarPorEmpresa($id_empresa);
$total_candidatos = Postulacion::contarPorEmpresa($id_empresa);
$total_aceptados = Postulacion::contarAceptadosPorEmpresa($id_empresa);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nattaworld — Panel empresa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/stylos.css">
    <link rel="stylesheet" href="../assets/css/botones.css">
</head>
<body>

    <?php include '../includes/navbar.php'; ?>

    <main>
        <div class="container mt-5">
            <h2 class="fw-bold">Bienvenido, <?php echo htmlspecialchars($_SESSION['nombre']); ?> 👋</h2>
            <p class="text-muted">Este es tu panel de empresa.</p>

            <!-- Estadisticas -->
            <div class="row g-4 mt-2">
                <div class="col-md-4">
                    <div class="card shadow-sm">
                        <div class="card-body text-center p-4">
                            <div class="display-5 fw-bold text-primary"><?php echo $total_ofertas; ?></div>
                            <small class="text-muted">Ofertas activas</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card shadow-sm">
                        <div class="card-body text-center p-4">
                            <div class="display-5 fw-bold text-success"><?php echo $total_candidatos; ?></div>
                            <small class="text-muted">Candidatos recibidos</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card shadow-sm">
                        <div class="card-body text-center p-4">
                            <div class="display-5 fw-bold text-warning"><?php echo $total_aceptados; ?></div>
                            <small class="text-muted">Candidatos aceptados</small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Accesos -->
            <div class="row g-4 mt-2">
                <div class="col-md-6">
                    <div class="card shadow-sm h-100">
                        <div class="card-body p-4 text-center">
                            <h5 class="fw-bold">Publicar oferta</h5>
                            <p class="text-muted">Crea una nueva oferta para atraer talento junior.</p>
                            <a href="crear_oferta.php" class="btn btn-success">Crear oferta</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card shadow-sm h-100">
                        <div class="card-body p-4 text-center">
                            <h5 class="fw-bold">Mis ofertas</h5>
                            <p class="text-muted">Gestiona tus ofertas publicadas y revisa los candidatos.</p>
                            <a href="mis_ofertas.php" class="btn btn-outline-primary">Ver mis ofertas</a>
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