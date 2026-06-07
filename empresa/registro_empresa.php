<?php
session_start();
require_once '../includes/Empresa.class.php';

$errores = [];
$nif = $nombre = $correo = $telefono = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nif       = trim($_POST['nif'] ?? '');
    $nombre    = trim($_POST['nombre'] ?? '');
    $correo    = trim($_POST['correo'] ?? '');
    $contrasena = $_POST['contrasena'] ?? '';
    $telefono  = trim($_POST['telefono'] ?? '');

    // Acepta DNI/NIF (8 dígitos + letra), NIE (X/Y/Z + 7 dígitos + letra)
    // y CIF (letra + 7 dígitos + dígito o letra de control)
    $regex_nif = "/^([0-9]{8}[A-Za-z]|[XYZxyz][0-9]{7}[A-Za-z]|[A-Za-z][0-9]{7}[0-9A-Za-z])$/";

    // --- Validaciones de servidor ---
    if ($nif === '') {
        $errores['nif'] = "El NIF/CIF es obligatorio.";
    } elseif (!preg_match($regex_nif, $nif)) {
        $errores['nif'] = "Identificador no válido. Introduce un DNI (12345678A), NIE (X1234567A) o CIF (B12345678).";
    }

    if ($nombre === '') {
        $errores['nombre'] = "El nombre de la empresa es obligatorio.";
    } elseif (mb_strlen($nombre) < 2) {
        $errores['nombre'] = "El nombre debe tener al menos 2 caracteres.";
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
    if (!isset($errores['correo']) && Empresa::correoExiste($correo)) {
        $errores['correo'] = "El correo ya está registrado.";
    }

    // Si no hay errores, registrar
    if (empty($errores)) {
        if (Empresa::registrar($nif, $nombre, $correo, $contrasena, $telefono)) {
            header('Location: ../login.php?mensaje=registro_exitoso');
            exit();
        } else {
            $errores['general'] = "Error al registrar la empresa. Verifica que el NIF no esté duplicado.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nattaworld — Registro empresa</title>
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
                    <div class="text-center mb-4">
                        <h2 class="fw-bold">Publica para juniors</h2>
                        <p class="text-muted">Crea tu cuenta de empresa</p>
                    </div>
                    <?php if (isset($errores['general'])): ?>
                        <div class="alert alert-danger"><?php echo $errores['general']; ?></div>
                    <?php endif; ?>
                    <div class="card shadow-sm">
                        <div class="card-body p-4">
                            <form method="POST" novalidate>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">NIF / CIF</label>
                                        <input type="text" name="nif"
                                               class="form-control <?php echo isset($errores['nif']) ? 'is-invalid' : ''; ?>"
                                               value="<?php echo htmlspecialchars($nif); ?>" required>
                                        <?php if (isset($errores['nif'])): ?>
                                            <div class="invalid-feedback"><?php echo $errores['nif']; ?></div>
                                        <?php endif; ?>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Nombre de la empresa</label>
                                        <input type="text" name="nombre"
                                               class="form-control <?php echo isset($errores['nombre']) ? 'is-invalid' : ''; ?>"
                                               value="<?php echo htmlspecialchars($nombre); ?>" required>
                                        <?php if (isset($errores['nombre'])): ?>
                                            <div class="invalid-feedback"><?php echo $errores['nombre']; ?></div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Correo corporativo</label>
                                    <input type="email" name="correo"
                                           class="form-control <?php echo isset($errores['correo']) ? 'is-invalid' : ''; ?>"
                                           value="<?php echo htmlspecialchars($correo); ?>" required>
                                    <?php if (isset($errores['correo'])): ?>
                                        <div class="invalid-feedback"><?php echo $errores['correo']; ?></div>
                                    <?php endif; ?>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Contrasena</label>
                                        <input type="password" name="contrasena"
                                               class="form-control <?php echo isset($errores['contrasena']) ? 'is-invalid' : ''; ?>"
                                               required>
                                        <?php if (isset($errores['contrasena'])): ?>
                                            <div class="invalid-feedback"><?php echo $errores['contrasena']; ?></div>
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
                                <button type="submit" class="btn btn-success w-100">Crear cuenta empresa</button>
                            </form>
                        </div>
                    </div>
                    <div class="text-center mt-3">
                        <p>Ya tienes cuenta? <a href="../login.php">Inicia sesion</a></p>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <?php include '../includes/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>