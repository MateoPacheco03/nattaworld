<?php
session_start();
require_once '../config/database.php';

// Solo candidatos
if (!isset($_SESSION['id']) || $_SESSION['rol'] != 'candidato') {
    header('Location: ../login.php');
    exit();
}

$errores = [];
$id = $_SESSION['id'];

// Procesar actualizacion
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre    = trim($_POST['nombre'] ?? '');
    $apellido1 = trim($_POST['apellido1'] ?? '');
    $apellido2 = trim($_POST['apellido2'] ?? '');
    $telefono  = trim($_POST['telefono'] ?? '');

    // Expresión para nombres: letras (con acentos y ñ) y espacios
    $regex_nombre = "/^[a-zA-ZáéíóúÁÉÍÓÚñÑüÜ ]+$/";

    // --- Validaciones de los campos de texto ---
    if ($nombre === '') {
        $errores['nombre'] = "El nombre es obligatorio.";
    } elseif (mb_strlen($nombre) < 2) {
        $errores['nombre'] = "El nombre debe tener al menos 2 caracteres.";
    } elseif (!preg_match($regex_nombre, $nombre)) {
        $errores['nombre'] = "El nombre solo puede contener letras.";
    }

    if ($apellido1 === '') {
        $errores['apellido1'] = "El primer apellido es obligatorio.";
    } elseif (mb_strlen($apellido1) < 2) {
        $errores['apellido1'] = "El apellido debe tener al menos 2 caracteres.";
    } elseif (!preg_match($regex_nombre, $apellido1)) {
        $errores['apellido1'] = "El apellido solo puede contener letras.";
    }

    if ($apellido2 !== '' && !preg_match($regex_nombre, $apellido2)) {
        $errores['apellido2'] = "El segundo apellido solo puede contener letras.";
    }

    if ($telefono !== '' && !preg_match("/^[0-9]{9}$/", $telefono)) {
        $errores['telefono'] = "El teléfono debe tener 9 dígitos.";
    }

    // --- Gestión de la subida del CV (si se ha enviado un archivo) ---
    $nombre_cv = null;
    if (isset($_FILES['cv']) && $_FILES['cv']['error'] == 0) {
        $tamano = $_FILES['cv']['size'];

        // Comprobar el tipo real del archivo (no el que dice el navegador)
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $tipo_real = finfo_file($finfo, $_FILES['cv']['tmp_name']);
        finfo_close($finfo);

        if ($tipo_real != 'application/pdf') {
            $errores['cv'] = "El CV debe ser un archivo PDF.";
        } elseif ($tamano > 2 * 1024 * 1024) {
            $errores['cv'] = "El CV no puede superar los 2MB.";
        } elseif (empty($errores)) {
            // Solo guardamos el archivo si el resto del formulario es válido
            $nombre_limpio = $nombre . '_' . $apellido1 . ($apellido2 ? '_' . $apellido2 : '');
            $nombre_limpio = strtolower($nombre_limpio);
            $nombre_limpio = str_replace(' ', '_', $nombre_limpio);
            $nombre_limpio = preg_replace('/[^a-z0-9_]/', '', iconv('UTF-8', 'ASCII//TRANSLIT', $nombre_limpio));
            $nombre_cv = 'cv_' . $nombre_limpio . '_' . date('Y-m-d_H-i-s') . '_' . $id . '.pdf';

            $ruta_destino = $_SERVER['DOCUMENT_ROOT'] . '/juniorworld/uploads/cv/' . $nombre_cv;
            if (!move_uploaded_file($_FILES['cv']['tmp_name'], $ruta_destino)) {
                $errores['cv'] = "No se pudo guardar el CV.";
                $nombre_cv = null;
            }
        }
    }

    // Si no hay ningún error, actualizar
    if (empty($errores)) {
        if ($nombre_cv != null) {
            $stmt = $conexion->prepare("UPDATE USUARIO SET nombre = :nombre, apellido1 = :apellido1, apellido2 = :apellido2, telefono = :telefono, cv = :cv WHERE id = :id");
            $stmt->bindParam(':cv', $nombre_cv);
        } else {
            $stmt = $conexion->prepare("UPDATE USUARIO SET nombre = :nombre, apellido1 = :apellido1, apellido2 = :apellido2, telefono = :telefono WHERE id = :id");
        }
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':apellido1', $apellido1);
        $stmt->bindParam(':apellido2', $apellido2);
        $stmt->bindParam(':telefono', $telefono);
        $stmt->bindParam(':id', $id);

        if ($stmt->execute()) {
            $_SESSION['nombre'] = $nombre;
            header('Location: panel.php?mensaje=perfil_actualizado');
            exit();
        } else {
            $errores['general'] = "Error al actualizar el perfil.";
        }
    }
}

// Obtener datos actuales
$stmt = $conexion->prepare("SELECT nombre, apellido1, apellido2, correo, telefono, cv FROM USUARIO WHERE id = :id LIMIT 1");
$stmt->bindParam(':id', $id);
$stmt->execute();
$usuario = $stmt->fetch(PDO::FETCH_ASSOC);

// Si venimos de un POST con errores, conservar lo que el usuario escribió
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $usuario['nombre']    = $nombre;
    $usuario['apellido1'] = $apellido1;
    $usuario['apellido2'] = $apellido2;
    $usuario['telefono']  = $telefono;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nattaworld — Editar perfil</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/stylos.css">
    <link rel="stylesheet" href="../assets/css/botones.css">
    <link rel="icon" type="image/png" sizes="32x32" href="/juniorworld/assets/img/iconos/iconoNattaworld.png">   
</head>
<body>

    <?php include '../includes/navbar.php'; ?>

    <main>
        <div class="container mt-5">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <h2 class="fw-bold mb-4">Editar mi perfil</h2>
                    <?php if (isset($errores['general'])): ?>
                        <div class="alert alert-danger"><?php echo $errores['general']; ?></div>
                    <?php endif; ?>
                    <div class="card shadow-sm">
                        <div class="card-body p-4">
                            <form method="POST" enctype="multipart/form-data" novalidate>
                                <div class="mb-3">
                                    <label class="form-label">Nombre</label>
                                    <input type="text" name="nombre"
                                           class="form-control <?php echo isset($errores['nombre']) ? 'is-invalid' : ''; ?>"
                                           value="<?php echo htmlspecialchars($usuario['nombre']); ?>" required>
                                    <?php if (isset($errores['nombre'])): ?>
                                        <div class="invalid-feedback"><?php echo $errores['nombre']; ?></div>
                                    <?php endif; ?>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Apellido 1</label>
                                        <input type="text" name="apellido1"
                                               class="form-control <?php echo isset($errores['apellido1']) ? 'is-invalid' : ''; ?>"
                                               value="<?php echo htmlspecialchars($usuario['apellido1']); ?>" required>
                                        <?php if (isset($errores['apellido1'])): ?>
                                            <div class="invalid-feedback"><?php echo $errores['apellido1']; ?></div>
                                        <?php endif; ?>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Apellido 2</label>
                                        <input type="text" name="apellido2"
                                               class="form-control <?php echo isset($errores['apellido2']) ? 'is-invalid' : ''; ?>"
                                               value="<?php echo htmlspecialchars($usuario['apellido2']); ?>">
                                        <?php if (isset($errores['apellido2'])): ?>
                                            <div class="invalid-feedback"><?php echo $errores['apellido2']; ?></div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Correo</label>
                                    <input type="email" class="form-control" value="<?php echo htmlspecialchars($usuario['correo']); ?>" disabled>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Telefono</label>
                                    <input type="tel" name="telefono"
                                           class="form-control <?php echo isset($errores['telefono']) ? 'is-invalid' : ''; ?>"
                                           value="<?php echo htmlspecialchars($usuario['telefono']); ?>">
                                    <?php if (isset($errores['telefono'])): ?>
                                        <div class="invalid-feedback"><?php echo $errores['telefono']; ?></div>
                                    <?php endif; ?>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Curriculum (PDF, max 2MB)</label>
                                    <input type="file" name="cv"
                                           class="form-control <?php echo isset($errores['cv']) ? 'is-invalid' : ''; ?>"
                                           accept="application/pdf">
                                    <?php if (isset($errores['cv'])): ?>
                                        <div class="invalid-feedback"><?php echo $errores['cv']; ?></div>
                                    <?php endif; ?>
                                    <?php if (!empty($usuario['cv'])): ?>
                                        <small class="text-muted d-block mt-2">
                                            CV actual: <a href="../uploads/cv/<?php echo htmlspecialchars($usuario['cv']); ?>" target="_blank">Ver CV subido</a>
                                        </small>
                                    <?php endif; ?>
                                </div>
                                <button type="submit" class="btn btn-success w-100">Guardar cambios</button>
                                <a href="panel.php" class="btn btn-outline-secondary w-100 mt-2">Cancelar</a>
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