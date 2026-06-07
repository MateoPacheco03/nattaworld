<?php
session_start();
require_once '../includes/Oferta.class.php';

// Solo las empresas pueden crear ofertas
if (!isset($_SESSION['id']) || $_SESSION['rol'] != 'empresa') {
    header('Location: ../login.php');
    exit();
}

$errores = [];
$titulo = $descripcion = $ubicacion = $area = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $titulo      = trim($_POST['titulo'] ?? '');
    $descripcion = trim($_POST['descripcion'] ?? '');
    $ubicacion   = trim($_POST['ubicacion'] ?? '');
    $area        = trim($_POST['area'] ?? '');
    $id_empresa  = $_SESSION['id'];

    // --- Validaciones de servidor ---
    if ($titulo === '') {
        $errores['titulo'] = "El título es obligatorio.";
    } elseif (mb_strlen($titulo) < 3) {
        $errores['titulo'] = "El título debe tener al menos 3 caracteres.";
    } elseif (mb_strlen($titulo) > 100) {
        $errores['titulo'] = "El título no puede superar los 100 caracteres.";
    }

    if ($area === '') {
        $errores['area'] = "El área profesional es obligatoria.";
    } elseif (mb_strlen($area) < 2) {
        $errores['area'] = "El área debe tener al menos 2 caracteres.";
    }

    if ($ubicacion !== '' && mb_strlen($ubicacion) > 100) {
        $errores['ubicacion'] = "La ubicación no puede superar los 100 caracteres.";
    }

    if (mb_strlen($descripcion) > 2000) {
        $errores['descripcion'] = "La descripción no puede superar los 2000 caracteres.";
    }

    // Si no hay errores, crear la oferta
    if (empty($errores)) {
        if (Oferta::crear($id_empresa, $titulo, $descripcion, $ubicacion, $area)) {
            header('Location: mis_ofertas.php?mensaje=oferta_creada');
            exit();
        } else {
            $errores['general'] = "Error al crear la oferta.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nattaworld — Publicar oferta</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/stylos.css">
</head>
<body>

    <?php include '../includes/navbar.php'; ?>

    <main>
        <div class="container mt-5">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <h2 class="fw-bold mb-4">Publicar nueva oferta</h2>
                    <?php if (isset($errores['general'])): ?>
                        <div class="alert alert-danger"><?php echo $errores['general']; ?></div>
                    <?php endif; ?>
                    <div class="card shadow-sm">
                        <div class="card-body p-4">
                            <form method="POST" novalidate>
                                <div class="mb-3">
                                    <label class="form-label">Titulo de la oferta</label>
                                    <input type="text" name="titulo"
                                           class="form-control <?php echo isset($errores['titulo']) ? 'is-invalid' : ''; ?>"
                                           value="<?php echo htmlspecialchars($titulo); ?>" required>
                                    <?php if (isset($errores['titulo'])): ?>
                                        <div class="invalid-feedback"><?php echo $errores['titulo']; ?></div>
                                    <?php endif; ?>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Area profesional</label>
                                        <input type="text" name="area"
                                               class="form-control <?php echo isset($errores['area']) ? 'is-invalid' : ''; ?>"
                                               value="<?php echo htmlspecialchars($area); ?>"
                                               placeholder="Ej: Tecnologia, Marketing, Diseno" required>
                                        <?php if (isset($errores['area'])): ?>
                                            <div class="invalid-feedback"><?php echo $errores['area']; ?></div>
                                        <?php endif; ?>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Ubicacion</label>
                                        <input type="text" name="ubicacion"
                                               class="form-control <?php echo isset($errores['ubicacion']) ? 'is-invalid' : ''; ?>"
                                               value="<?php echo htmlspecialchars($ubicacion); ?>"
                                               placeholder="Ej: Madrid, Remoto">
                                        <?php if (isset($errores['ubicacion'])): ?>
                                            <div class="invalid-feedback"><?php echo $errores['ubicacion']; ?></div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Descripcion</label>
                                    <textarea name="descripcion" rows="5"
                                              class="form-control <?php echo isset($errores['descripcion']) ? 'is-invalid' : ''; ?>"><?php echo htmlspecialchars($descripcion); ?></textarea>
                                    <?php if (isset($errores['descripcion'])): ?>
                                        <div class="invalid-feedback"><?php echo $errores['descripcion']; ?></div>
                                    <?php endif; ?>
                                </div>
                                <button type="submit" class="btn btn-success w-100">Publicar oferta</button>
                                <a href="mis_ofertas.php" class="btn btn-outline-secondary w-100 mt-2">Cancelar</a>
                            </form>
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