<?php
session_start();
require_once '../includes/Oferta.class.php';
require_once '../includes/Postulacion.class.php';
require_once '../config/database.php';

if (!isset($_GET['id'])) {
    header('Location: ../ofertas.php');
    exit();
}

$id_oferta = $_GET['id'];
$oferta = Oferta::obtener($id_oferta);

if (!$oferta) {
    header('Location: ../ofertas.php');
    exit();
}

// Si el candidato esta logueado, comprobamos si ya tiene CV en su perfil y si ya se postulo
$cv_perfil = null;
$ya_postulado = false;
if (isset($_SESSION['id']) && $_SESSION['rol'] == 'candidato') {
    $stmt = $conexion->prepare("SELECT cv FROM USUARIO WHERE id = :id LIMIT 1");
    $stmt->bindParam(':id', $_SESSION['id']);
    $stmt->execute();
    $datos = $stmt->fetch(PDO::FETCH_ASSOC);
    $cv_perfil = $datos['cv'];

    $ya_postulado = Postulacion::yaPostulado($_SESSION['id'], $id_oferta);
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Natt World — <?php echo htmlspecialchars($oferta['titulo']); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/stylos.css">
    <link rel="stylesheet" href="../assets/css/botones.css">
</head>
<body>

    <?php include '../includes/navbar.php'; ?>

    <main>
        <div class="container mt-5">
            <a href="../ofertas.php" class="text-muted" style="text-decoration:none;">← Volver a ofertas</a>

            <div class="row mt-3">
                <!-- Detalle de la oferta -->
                <div class="col-md-8">
                    <div class="card shadow-sm">
                        <div class="card-body p-4">
                            <small class="text-muted"><?php echo htmlspecialchars($oferta['empresa']); ?></small>
                            <h2 class="fw-bold"><?php echo htmlspecialchars($oferta['titulo']); ?></h2>
                            <div class="mb-3">
                                <span class="badge bg-light text-dark">📍 <?php echo htmlspecialchars($oferta['ubicacion']); ?></span>
                                <span class="badge bg-light text-dark"><?php echo htmlspecialchars($oferta['area']); ?></span>
                                <span class="badge bg-light text-dark">📅 <?php echo $oferta['fecha']; ?></span>
                            </div>
                            <h5 class="fw-bold mt-4">Descripción</h5>
                            <p style="line-height:1.7;"><?php echo nl2br(htmlspecialchars($oferta['descripcion'])); ?></p>
                        </div>
                    </div>
                </div>

                <!-- Panel de postulacion -->
                <div class="col-md-4">
                    <div class="card shadow-sm">
                        <div class="card-body p-4">
                            <h5 class="fw-bold mb-3">Postúlate a esta oferta</h5>

                            <?php if (isset($_GET['error'])): ?>
                                <?php if ($_GET['error'] == 'sin_cv'): ?>
                                    <div class="alert alert-warning" style="font-size:13px;">Necesitas un CV para postularte. Sube uno aquí o añádelo en tu <a href="editar_perfil.php">perfil</a>.</div>
                                <?php elseif ($_GET['error'] == 'formato'): ?>
                                    <div class="alert alert-danger" style="font-size:13px;">El CV debe ser un archivo PDF.</div>
                                <?php elseif ($_GET['error'] == 'tamano'): ?>
                                    <div class="alert alert-danger" style="font-size:13px;">El CV no puede superar los 2MB.</div>
                                <?php elseif ($_GET['error'] == 'subida'): ?>
                                    <div class="alert alert-danger" style="font-size:13px;">No se pudo subir el CV. Inténtalo de nuevo.</div>
                                <?php endif; ?>
                            <?php endif; ?>

                            <?php if (!isset($_SESSION['id']) || $_SESSION['rol'] != 'candidato'): ?>
                                <p class="text-muted" style="font-size:14px;">Inicia sesión como candidato para postularte.</p>
                                <a href="../login.php" class="btn btn-success w-100">Iniciar sesión</a>

                            <?php elseif ($ya_postulado): ?>
                                <div class="alert alert-info">Ya te has postulado a esta oferta.</div>
                                <a href="mis_postulaciones.php" class="btn btn-outline-primary w-100">Ver mis postulaciones</a>

                            <?php else: ?>
                                <form method="POST" action="postular.php" enctype="multipart/form-data">
                                    <input type="hidden" name="id_oferta" value="<?php echo $oferta['id']; ?>">

                                    <label class="form-label fw-bold" style="font-size:14px;">¿Qué CV quieres enviar?</label>

                                    <?php if (!empty($cv_perfil)): ?>
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="radio" name="opcion_cv" value="perfil" id="cvPerfil" checked>
                                            <label class="form-check-label" for="cvPerfil" style="font-size:14px;">
                                                Usar el CV de mi perfil
                                            </label>
                                        </div>
                                        <div class="form-check mb-3">
                                            <input class="form-check-input" type="radio" name="opcion_cv" value="nuevo" id="cvNuevo">
                                            <label class="form-check-label" for="cvNuevo" style="font-size:14px;">
                                                Subir un CV diferente
                                            </label>
                                        </div>
                                    <?php else: ?>
                                        <p class="text-muted" style="font-size:13px;">No tienes CV en tu perfil. Sube uno para esta oferta:</p>
                                        <input type="hidden" name="opcion_cv" value="nuevo">
                                    <?php endif; ?>

                                    <div class="mb-3" id="campoArchivo" <?php echo !empty($cv_perfil) ? 'style="display:none;"' : ''; ?>>
                                        <input type="file" name="cv_nuevo" class="form-control" accept="application/pdf">
                                        <small class="text-muted">PDF, máximo 2MB</small>
                                    </div>

                                    <button type="submit" class="btn btn-success w-100">Postularme</button>
                                </form>

                                <script>
                                    document.querySelectorAll('input[name="opcion_cv"]').forEach(function(radio) {
                                        radio.addEventListener('change', function() {
                                            document.getElementById('campoArchivo').style.display = (this.value === 'nuevo') ? 'block' : 'none';
                                        });
                                    });
                                </script>
                            <?php endif; ?>

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