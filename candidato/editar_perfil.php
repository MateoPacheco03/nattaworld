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
        $stmt = $conexion->prepare("UPDATE USUARIO SET nombre = :nombre, apellido1 = :apellido1, apellido2 = :apellido2, telefono = :telefono WHERE id = :id");
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
    } else {
        $errores = "El nombre y el primer apellido son obligatorios";
    }
}

// Obtener datos actuales
$stmt = $conexion->prepare("SELECT nombre, apellido1, apellido2, correo, telefono FROM USUARIO WHERE id = :id LIMIT 1");
$stmt->bindParam(':id', $id);
$stmt->execute();
$usuario = $stmt->fetch(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Natt World — Editar perfil</title>
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
                            <form method="POST">
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