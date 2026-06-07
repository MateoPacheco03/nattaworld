<?php
session_start();
require_once 'config/database.php';

$errores = "";
$correo = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $correo = trim($_POST['correo'] ?? '');
    $contrasena = $_POST['contrasena'] ?? '';

    // Validación básica de campos
    if ($correo === '' || $contrasena === '') {
        $errores = "Debes rellenar el correo y la contraseña.";
    } elseif (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
        $errores = "Introduce un correo electrónico válido.";
    } else {
        // Verificar si es administrador
        $stmt = $conexion->prepare("SELECT id, nombre, apellido1, contrasena FROM ADMINISTRADOR WHERE correo = :correo LIMIT 1");
        $stmt->bindParam(':correo', $correo);
        $stmt->execute();
        $datos = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($datos && password_verify($contrasena, $datos['contrasena'])) {
            $_SESSION['id'] = $datos['id'];
            $_SESSION['nombre'] = $datos['nombre'];
            $_SESSION['apellido1'] = $datos['apellido1'];
            $_SESSION['rol'] = 'admin';
            header('Location: admin/panel_admin.php');
            exit();
        }

        // Verificar si es candidato
        $stmt = $conexion->prepare("SELECT id, nombre, apellido1, contrasena FROM USUARIO WHERE correo = :correo LIMIT 1");
        $stmt->bindParam(':correo', $correo);
        $stmt->execute();
        $datos = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($datos && password_verify($contrasena, $datos['contrasena'])) {
            $_SESSION['id'] = $datos['id'];
            $_SESSION['nombre'] = $datos['nombre'];
            $_SESSION['apellido1'] = $datos['apellido1'];
            $_SESSION['rol'] = 'candidato';
            header('Location: candidato/panel.php');
            exit();
        }

        // Verificar si es empresa
        $stmt = $conexion->prepare("SELECT id, nombre, contrasena FROM EMPRESA WHERE correo = :correo LIMIT 1");
        $stmt->bindParam(':correo', $correo);
        $stmt->execute();
        $datos = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($datos && password_verify($contrasena, $datos['contrasena'])) {
            $_SESSION['id'] = $datos['id'];
            $_SESSION['nombre'] = $datos['nombre'];
            $_SESSION['rol'] = 'empresa';
            header('Location: empresa/panel_empresa.php');
            exit();
        }

        // Si llega aquí, las credenciales no son correctas
        $errores = "Correo o contrasena incorrectos";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nattaworld — Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./assets/css/stylos.css">
    <link rel="stylesheet" href="./assets/css/botones.css">
</head>
<body>

    <?php @include_once('./includes/navbar.php'); ?>

    <main>
        <div class="container mt-5">
            <div class="row justify-content-center">
                <div class="col-md-5">
                    <div class="text-center mb-4">
                        <h2 class="fw-bold">Nattaworld</h2>
                        <p class="text-muted">Inicia sesion en tu cuenta</p>
                    </div>
                    <?php if (isset($_GET['mensaje']) && $_GET['mensaje'] == 'registro_exitoso'): ?>
                        <div class="alert alert-success">Registro exitoso. Ya puedes iniciar sesion.</div>
                    <?php endif; ?>
                    <?php if ($errores): ?>
                        <div class="alert alert-danger"><?php echo $errores; ?></div>
                    <?php endif; ?>
                    <div class="card shadow-sm">
                        <div class="card-body p-4">
                            <form method="POST" novalidate>
                                <div class="mb-3">
                                    <label class="form-label">Correo electronico</label>
                                    <input type="email" name="correo" class="form-control" value="<?php echo htmlspecialchars($correo); ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Contrasena</label>
                                    <input type="password" name="contrasena" class="form-control" required>
                                </div>
                                <button type="submit" class="btn btn-primary w-100">Iniciar sesion</button>
                            </form>
                        </div>
                    </div>
                    <div class="text-center mt-3">
                        <p>No tienes cuenta? <a href="registro_tipo.php">Registrate</a></p>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <?php @include_once('./includes/footer.php'); ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>