<?php
session_start();
require_once '../includes/Empresa.class.php';

$errores = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nif = htmlspecialchars($_POST['nif']);
    $nombre = htmlspecialchars($_POST['nombre']);
    $correo = htmlspecialchars($_POST['correo']);
    $contrasena = $_POST['contrasena'];
    $telefono = htmlspecialchars($_POST['telefono']);

    if (Empresa::correoExiste($correo)) {
        $errores = "El correo ya esta registrado";
    } else {
        if (Empresa::registrar($nif, $nombre, $correo, $contrasena, $telefono)) {
            header('Location: ../login.php?mensaje=registro_exitoso');
            exit();
        } else {
            $errores = "Error al registrar la empresa. Verifica que el NIF no este duplicado.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NattaWorld — Registro empresa</title>
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
            <?php if ($errores): ?>
                <div class="alert alert-danger"><?php echo $errores; ?></div>
            <?php endif; ?>
            <div class="card shadow-sm">
                <div class="card-body p-4">
                    <form method="POST">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">NIF / CIF</label>
                                <input type="text" name="nif" class="form-control" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Nombre de la empresa</label>
                                <input type="text" name="nombre" class="form-control" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Correo corporativo</label>
                            <input type="email" name="correo" class="form-control" required>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Contrasena</label>
                                <input type="password" name="contrasena" class="form-control" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Telefono</label>
                                <input type="tel" name="telefono" class="form-control">
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