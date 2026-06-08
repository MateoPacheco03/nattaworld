<?php
session_start();
require_once 'config/database.php';

$errores = [];
$nombre = $apellido1 = $apellido2 = $correo = $telefono = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre    = trim($_POST['nombre'] ?? '');
    $apellido1 = trim($_POST['apellido1'] ?? '');
    $apellido2 = trim($_POST['apellido2'] ?? '');
    $correo    = trim($_POST['correo'] ?? '');
    $contrasena = $_POST['contrasena'] ?? '';
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

    if ($correo === '') {
        $errores['correo'] = "El correo es obligatorio.";
    } elseif (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
        $errores['correo'] = "Introduce un correo electrónico válido.";
    }

    if ($contrasena === '') {
        $errores['contrasena'] = "La contraseña es obligatoria.";
    } elseif (mb_strlen($contrasena) < 6) {
        $errores['contrasena'] = "La contraseña debe tener al menos 6 caracteres.";
    }

    if ($telefono !== '' && !preg_match("/^[0-9]{9}$/", $telefono)) {
        $errores['telefono'] = "El teléfono debe tener 9 dígitos.";
    }

    // Comprobar correo duplicado solo si el formato es válido
    if (!isset($errores['correo'])) {
        $declaracion = $conexion->prepare("SELECT id FROM USUARIO WHERE correo = :correo LIMIT 1");
        $declaracion->bindParam(':correo', $correo);
        $declaracion->execute();
        if ($declaracion->rowCount() > 0) {
            $errores['correo'] = "El correo ya está registrado.";
        }
    }

    // Si no hay errores, registrar
    if (empty($errores)) {
        $contrasena_cifrada = password_hash($contrasena, PASSWORD_BCRYPT);
        $declaracion = $conexion->prepare("INSERT INTO USUARIO (nombre, apellido1, apellido2, correo, contrasena, telefono) VALUES (:nombre, :apellido1, :apellido2, :correo, :contrasena, :telefono)");
        $declaracion->bindParam(':nombre', $nombre);
        $declaracion->bindParam(':apellido1', $apellido1);
        $declaracion->bindParam(':apellido2', $apellido2);
        $declaracion->bindParam(':correo', $correo);
        $declaracion->bindParam(':contrasena', $contrasena_cifrada);
        $declaracion->bindParam(':telefono', $telefono);

        if ($declaracion->execute()) {
            header('Location: login.php?mensaje=registro_exitoso');
            exit();
        } else {
            $errores['general'] = "Error al registrar el usuario.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro — Nattaworld</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./assets/css/stylos.css">
    <link rel="stylesheet" href="./assets/css/botones.css">
    <link rel="icon" type="image/png" sizes="32x32" href="/nattaworld/assets/img/iconos/iconoNattaworld.png">   

</head>
<body>

    <?php @include_once('./includes/navbar.php'); ?>

    <main>
        <div class="container mt-5">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="text-center mb-4">
                        <h2 class="fw-bold">Nattaworld</h2>
                        <p class="text-muted">Crea tu cuenta como candidato</p>
                    </div>
                    <?php if (isset($errores['general'])): ?>
                        <div class="alert alert-danger"><?php echo $errores['general']; ?></div>
                    <?php endif; ?>
                    <div class="card shadow-sm">
                        <div class="card-body p-4">
                            <form method="POST" novalidate>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Nombre</label>
                                        <input type="text" name="nombre"
                                               class="form-control <?php echo isset($errores['nombre']) ? 'is-invalid' : ''; ?>"
                                               value="<?php echo htmlspecialchars($nombre); ?>" required>
                                        <?php if (isset($errores['nombre'])): ?>
                                            <div class="invalid-feedback"><?php echo $errores['nombre']; ?></div>
                                        <?php endif; ?>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Apellido 1</label>
                                        <input type="text" name="apellido1"
                                               class="form-control <?php echo isset($errores['apellido1']) ? 'is-invalid' : ''; ?>"
                                               value="<?php echo htmlspecialchars($apellido1); ?>" required>
                                        <?php if (isset($errores['apellido1'])): ?>
                                            <div class="invalid-feedback"><?php echo $errores['apellido1']; ?></div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Apellido 2</label>
                                        <input type="text" name="apellido2"
                                               class="form-control <?php echo isset($errores['apellido2']) ? 'is-invalid' : ''; ?>"
                                               value="<?php echo htmlspecialchars($apellido2); ?>">
                                        <?php if (isset($errores['apellido2'])): ?>
                                            <div class="invalid-feedback"><?php echo $errores['apellido2']; ?></div>
                                        <?php endif; ?>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Telefono</label>
                                        <input type="tel" name="telefono"
                                               class="form-control <?php echo isset($errores['telefono']) ? 'is-invalid' : ''; ?>"
                                               value="<?php echo htmlspecialchars($telefono); ?>">
                                        <?php if (isset($errores['telefono'])): ?>
                                            <div class="invalid-feedback"><?php echo $errores['telefono']; ?></div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Correo electronico</label>
                                    <input type="email" name="correo"
                                           class="form-control <?php echo isset($errores['correo']) ? 'is-invalid' : ''; ?>"
                                           value="<?php echo htmlspecialchars($correo); ?>" required>
                                    <?php if (isset($errores['correo'])): ?>
                                        <div class="invalid-feedback"><?php echo $errores['correo']; ?></div>
                                    <?php endif; ?>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Contrasena</label>
                                    <input type="password" name="contrasena"
                                           class="form-control <?php echo isset($errores['contrasena']) ? 'is-invalid' : ''; ?>"
                                           required>
                                    <?php if (isset($errores['contrasena'])): ?>
                                        <div class="invalid-feedback"><?php echo $errores['contrasena']; ?></div>
                                    <?php endif; ?>
                                </div>
                                <button type="submit" class="btn btn-primary w-100">Crear cuenta</button>
                            </form>
                        </div>
                    </div>
                    <div class="text-center mt-3">
                        <p>Ya tienes cuenta? <a href="login.php">Inicia sesion</a></p>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <?php @include_once('./includes/footer.php'); ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>