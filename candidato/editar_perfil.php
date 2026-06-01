<?php
session_start();
require_once '../config/database.php';

// Solo candidatos
if (!isset($_SESSION['id']) || $_SESSION['rol'] != 'candidato') {
    header('Location: ../login.php');
    exit();
}

$errores = "";
$id = $_SESSION['id'];

// Procesar actualizacion
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = htmlspecialchars($_POST['nombre']);
    $apellido1 = htmlspecialchars($_POST['apellido1']);
    $apellido2 = htmlspecialchars($_POST['apellido2']);
    $telefono = htmlspecialchars($_POST['telefono']);

    if ($nombre && $apellido1) {

        // Gestion de la subida del CV (si se ha enviado un archivo)
        $nombre_cv = null;
        if (isset($_FILES['cv']) && $_FILES['cv']['error'] == 0) {
            $tipo = $_FILES['cv']['type'];
            $tamano = $_FILES['cv']['size'];

            // Validar que sea PDF y no supere 2MB
            if ($tipo != 'application/pdf') {
                $errores = "El CV debe ser un archivo PDF";
            } elseif ($tamano > 2 * 1024 * 1024) {
                $errores = "El CV no puede superar los 2MB";
            } else {
                // Nombre legible: cv_nombre_apellido1_apellido2_id.pdf
                $nombre_limpio = $nombre . '_' . $apellido1 . ($apellido2 ? '_' . $apellido2 : '');
                $nombre_limpio = strtolower($nombre_limpio);
                $nombre_limpio = str_replace(' ', '_', $nombre_limpio);
                $nombre_limpio = preg_replace('/[^a-z0-9_]/', '', iconv('UTF-8', 'ASCII//TRANSLIT', $nombre_limpio));
                $nombre_cv = 'cv_' . $nombre_limpio . '_' . date('Y-m-d_H-i-s') . '_' . $id . '.pdf';

                $ruta_destino = $_SERVER['DOCUMENT_ROOT'] . '/juniorworld/uploads/cv/' . $nombre_cv;
                if (!move_uploaded_file($_FILES['cv']['tmp_name'], $ruta_destino)) {
                    $errores = "No se pudo guardar el CV";
                    $nombre_cv = null;
                }
            }
        }

        if ($errores == "") {
            // Si subio CV nuevo, actualizamos tambien el campo cv
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
                $errores = "Error al actualizar el perfil";
            }
        }
    } else {
        $errores = "El nombre y el primer apellido son obligatorios";
    }
}

// Obtener datos actuales
$stmt = $conexion->prepare("SELECT nombre, apellido1, apellido2, correo, telefono, cv FROM USUARIO WHERE id = :id LIMIT 1");
$stmt->bindParam(':id', $id);
$stmt->execute();
$usuario = $stmt->fetch(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NattaWorld — Editar perfil</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/stylos.css">
    <link rel="stylesheet" href="../assets/css/botones.css">
</head>
<body>

    <?php include '../includes/navbar.php'; ?>

    <main>
        <div class="container mt-5">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <h2 class="fw-bold mb-4">Editar mi perfil</h2>
                    <?php if ($errores): ?>
                        <div class="alert alert-danger"><?php echo $errores; ?></div>
                    <?php endif; ?>
                    <div class="card shadow-sm">
                        <div class="card-body p-4">
                            <form method="POST" enctype="multipart/form-data">
                                <div class="mb-3">
                                    <label class="form-label">Nombre</label>
                                    <input type="text" name="nombre" class="form-control" value="<?php echo htmlspecialchars($usuario['nombre']); ?>" required>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Apellido 1</label>
                                        <input type="text" name="apellido1" class="form-control" value="<?php echo htmlspecialchars($usuario['apellido1']); ?>" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Apellido 2</label>
                                        <input type="text" name="apellido2" class="form-control" value="<?php echo htmlspecialchars($usuario['apellido2']); ?>">
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Correo</label>
                                    <input type="email" class="form-control" value="<?php echo htmlspecialchars($usuario['correo']); ?>" disabled>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Telefono</label>
                                    <input type="tel" name="telefono" class="form-control" value="<?php echo htmlspecialchars($usuario['telefono']); ?>">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Curriculum (PDF, max 2MB)</label>
                                    <input type="file" name="cv" class="form-control" accept="application/pdf">
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