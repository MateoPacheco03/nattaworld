<?php
session_start();
require_once '../config/database.php';

if (!isset($_SESSION['id']) || $_SESSION['rol'] != 'admin') {
    header('Location: ../login.php');
    exit();
}

$errores = [];
$usuario = null;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id        = $_POST['id'] ?? '';
    $nombre    = trim($_POST['nombre'] ?? '');
    $apellido1 = trim($_POST['apellido1'] ?? '');
    $apellido2 = trim($_POST['apellido2'] ?? '');
    $telefono  = trim($_POST['telefono'] ?? '');

    // Expresión para nombres: letras (con acentos y ñ) y espacios
    $regex_nombre = "/^[a-zA-ZáéíóúÁÉÍÓÚñÑüÜ ]+$/";

    // --- Validaciones de servidor ---
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

    if (empty($errores)) {
        $stmt = $conexion->prepare("UPDATE USUARIO SET nombre = :nombre, apellido1 = :apellido1, apellido2 = :apellido2, telefono = :telefono WHERE id = :id");
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':apellido1', $apellido1);
        $stmt->bindParam(':apellido2', $apellido2);
        $stmt->bindParam(':telefono', $telefono);
        $stmt->bindParam(':id', $id);

        if ($stmt->execute()) {
            header('Location: listar_usuarios.php');
            exit();
        } else {
            $errores['general'] = "Error al actualizar el usuario.";
        }
    }

    // Si hubo error, conservar lo que el admin acababa de escribir.
    // Recuperamos el correo de la BD (no se edita aquí).
    $stmt = $conexion->prepare("SELECT correo FROM USUARIO WHERE id = :id LIMIT 1");
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    $fila = $stmt->fetch(PDO::FETCH_ASSOC);

    $usuario = [
        'id'        => $id,
        'nombre'    => $nombre,
        'apellido1' => $apellido1,
        'apellido2' => $apellido2,
        'telefono'  => $telefono,
        'correo'    => $fila['correo'] ?? '',
    ];

} else {
    $id = $_GET['id'] ?? '';
    $stmt = $conexion->prepare("SELECT id, nombre, apellido1, apellido2, correo, telefono FROM USUARIO WHERE id = :id LIMIT 1");
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nattaworld — Editar usuario</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/stylos.css">
    <link rel="stylesheet" href="../assets/css/botones.css">
    <link rel="icon" type="image/png" sizes="32x32" href="/nattaworld/assets/img/iconos/iconoNattaworld.png">
</head>
<body>

    <?php include '../includes/navbar.php'; ?>

    <main>
        <div class="container mt-5">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <h2 class="fw-bold mb-4">Editar usuario</h2>
                    <?php if (isset($errores['general'])): ?>
                        <div class="alert alert-danger"><?php echo $errores['general']; ?></div>
                    <?php endif; ?>
                    <div class="card shadow-sm">
                        <div class="card-body p-4">
                            <form method="POST" novalidate>
                                <input type="hidden" name="id" value="<?php echo htmlspecialchars($usuario['id']); ?>">
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
                                <button type="submit" class="btn btn-success w-100">Guardar cambios</button>
                                <a href="listar_usuarios.php" class="btn btn-outline-secondary w-100 mt-2">Cancelar</a>
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