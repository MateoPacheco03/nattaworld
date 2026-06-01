<?php
session_start();
require_once '../includes/Estadisticas.class.php';

// Solo admin
if (!isset($_SESSION['id']) || $_SESSION['rol'] != 'admin') {
    header('Location: ../login.php');
    exit();
}

$total_usuarios = Estadisticas::totalUsuarios();
$total_empresas = Estadisticas::totalEmpresas();
$total_ofertas = Estadisticas::totalOfertas();
$total_postulaciones = Estadisticas::totalPostulaciones();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NattaWorld — Panel administrador</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/stylos.css">
    <link rel="stylesheet" href="../assets/css/botones.css">
</head>
<body>

    <?php include '../includes/navbar.php'; ?>

    <main>
        <div class="container mt-5">
            <h2 class="fw-bold">Panel de administrador</h2>
            <p class="text-muted">Resumen general del sistema.</p>

            <!-- Estadisticas -->
            <div class="row g-4 mt-2">
                <div class="col-md-3">
                    <div class="card shadow-sm">
                        <div class="card-body text-center p-4">
                            <div class="display-5 fw-bold text-primary"><?php echo $total_usuarios; ?></div>
                            <small class="text-muted">Usuarios registrados</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card shadow-sm">
                        <div class="card-body text-center p-4">
                            <div class="display-5 fw-bold text-success"><?php echo $total_empresas; ?></div>
                            <small class="text-muted">Empresas registradas</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card shadow-sm">
                        <div class="card-body text-center p-4">
                            <div class="display-5 fw-bold text-warning"><?php echo $total_ofertas; ?></div>
                            <small class="text-muted">Ofertas publicadas</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card shadow-sm">
                        <div class="card-body text-center p-4">
                            <div class="display-5 fw-bold text-danger"><?php echo $total_postulaciones; ?></div>
                            <small class="text-muted">Postulaciones totales</small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Accesos de gestion -->
            <div class="row g-4 mt-2">
                <div class="col-md-4">
                    <div class="card shadow-sm h-100">
                        <div class="card-body p-4 text-center">
                            <h5 class="fw-bold">Gestionar usuarios</h5>
                            <p class="text-muted">Ver, editar y eliminar candidatos registrados.</p>
                            <a href="listar_usuarios.php" class="btn btn-outline-primary">Usuarios</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card shadow-sm h-100">
                        <div class="card-body p-4 text-center">
                            <h5 class="fw-bold">Gestionar empresas</h5>
                            <p class="text-muted">Ver y administrar las empresas de la plataforma.</p>
                            <a href="listar_empresas.php" class="btn btn-outline-primary">Empresas</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card shadow-sm h-100">
                        <div class="card-body p-4 text-center">
                            <h5 class="fw-bold">Gestionar ofertas</h5>
                            <p class="text-muted">Revisar y moderar las ofertas publicadas.</p>
                            <a href="listar_ofertas.php" class="btn btn-outline-primary">Ofertas</a>
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