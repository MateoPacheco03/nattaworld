<?php
// contacto.php — Contacto · NattaWorld
session_start();

$errores = [];
$exito = false;

// Conservamos lo que el usuario escribió para no perderlo si hay error
$nombre  = "";
$correo  = "";
$asunto  = "";
$mensaje = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre  = trim($_POST['nombre'] ?? '');
    $correo  = trim($_POST['correo'] ?? '');
    $asunto  = trim($_POST['asunto'] ?? '');
    $mensaje = trim($_POST['mensaje'] ?? '');

    // --- Validaciones en el servidor ---
    if ($nombre === '') {
        $errores['nombre'] = "El nombre es obligatorio.";
    } elseif (mb_strlen($nombre) < 2) {
        $errores['nombre'] = "El nombre debe tener al menos 2 caracteres.";
    }

    if ($correo === '') {
        $errores['correo'] = "El correo es obligatorio.";
    } elseif (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
        $errores['correo'] = "Introduce un correo electrónico válido.";
    }

    if ($asunto === '') {
        $errores['asunto'] = "El asunto es obligatorio.";
    }

    if ($mensaje === '') {
        $errores['mensaje'] = "El mensaje es obligatorio.";
    } elseif (mb_strlen($mensaje) < 10) {
        $errores['mensaje'] = "El mensaje debe tener al menos 10 caracteres.";
    }

    // Si no hay errores, consideramos el envío correcto
    if (empty($errores)) {
        // Aquí podrías guardar el mensaje en la base de datos o enviarlo por email.
        $exito = true;
        // Limpiamos los campos tras el envío correcto
        $nombre = $correo = $asunto = $mensaje = "";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contacto — Nattaworld</title>
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
                <div class="col-md-7">
                    <div class="text-center mb-4">
                        <h2 class="fw-bold">Nattaworld</h2>
                        <p class="text-muted">¿Tienes alguna duda o propuesta? Escríbenos.</p>
                    </div>

                    <?php if ($exito): ?>
                        <div class="alert alert-success">
                            ¡Gracias por tu mensaje! Te responderemos lo antes posible.
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($errores)): ?>
                        <div class="alert alert-danger">
                            Revisa los campos marcados e inténtalo de nuevo.
                        </div>
                    <?php endif; ?>

                    <div class="card shadow-sm">
                        <div class="card-body p-4">
                            <form method="POST" novalidate>
                                <div class="mb-3">
                                    <label class="form-label">Nombre</label>
                                    <input type="text" name="nombre"
                                           class="form-control <?php echo isset($errores['nombre']) ? 'is-invalid' : ''; ?>"
                                           value="<?php echo htmlspecialchars($nombre); ?>" required>
                                    <?php if (isset($errores['nombre'])): ?>
                                        <div class="invalid-feedback"><?php echo $errores['nombre']; ?></div>
                                    <?php endif; ?>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Correo electrónico</label>
                                    <input type="email" name="correo"
                                           class="form-control <?php echo isset($errores['correo']) ? 'is-invalid' : ''; ?>"
                                           value="<?php echo htmlspecialchars($correo); ?>" required>
                                    <?php if (isset($errores['correo'])): ?>
                                        <div class="invalid-feedback"><?php echo $errores['correo']; ?></div>
                                    <?php endif; ?>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Asunto</label>
                                    <input type="text" name="asunto"
                                           class="form-control <?php echo isset($errores['asunto']) ? 'is-invalid' : ''; ?>"
                                           value="<?php echo htmlspecialchars($asunto); ?>" required>
                                    <?php if (isset($errores['asunto'])): ?>
                                        <div class="invalid-feedback"><?php echo $errores['asunto']; ?></div>
                                    <?php endif; ?>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Mensaje</label>
                                    <textarea name="mensaje" rows="6"
                                              class="form-control <?php echo isset($errores['mensaje']) ? 'is-invalid' : ''; ?>"
                                              required><?php echo htmlspecialchars($mensaje); ?></textarea>
                                    <?php if (isset($errores['mensaje'])): ?>
                                        <div class="invalid-feedback"><?php echo $errores['mensaje']; ?></div>
                                    <?php endif; ?>
                                </div>

                                <button type="submit" class="btn btn-primary w-100">Enviar mensaje</button>
                            </form>
                        </div>
                    </div>

                    <div class="text-center mt-4">
                        <p class="text-muted mb-1">También puedes escribirnos directamente a:</p>
                        <p><strong>hola@nattworld.es</strong></p>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <?php @include_once('./includes/footer.php'); ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>