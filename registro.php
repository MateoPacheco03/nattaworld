<?php 

session_start();
require_once 'config/database.php';

$errores = "";

// Comprobamos el metodo de ingreso del formulario
if($_SERVER['REQUEST_METHOD']=='POST'){
    $nombre = htmlspecialchars($_POST['nombre']);
    $apellido1 = htmlspecialchars($_POST['apellido1']);
    $apellido2 = htmlspecialchars($_POST['apellido2']);
    $correo = htmlspecialchars($_POST['correo']);
    $contrasena = $_POST['contrasena'];
    $telefono = htmlspecialchars($_POST['telefono']);

    $declaracion = $conexion->prepare("SELECT id FROM USUARIO WHERE correo = :correo LIMIT 1");
    $declaracion->bindParam(':correo',$correo);
    $declaracion->execute();

    if($declaracion->rowCount()>0){
        $errores = "El correo ya esta registrado";
    }else{
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
        }else{
            $errores = "Error al registrar el usuario";
        }
    }
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro — NattaWorld</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./assets/css/stylos.css">
    <link rel="stylesheet" href="./assets/css/botones.css">
</head>
<body>

    <?php @include_once('./includes/navbar.php'); ?>

    <main>
        <div class="container mt-5">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="text-center mb-4">
                        <h2 class="fw-bold">NattaWorld</h2>
                        <p class="text-muted">Crea tu cuenta como candidato</p>
                    </div>
                    <?php if ($errores): ?>
                        <div class="alert alert-danger"><?php echo $errores; ?></div>
                    <?php endif; ?>
                    <div class="card shadow-sm">
                        <div class="card-body p-4">
                            <form method="POST">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Nombre</label>
                                        <input type="text" name="nombre" class="form-control" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Apellido 1</label>
                                        <input type="text" name="apellido1" class="form-control" required>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Apellido 2</label>
                                        <input type="text" name="apellido2" class="form-control">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Telefono</label>
                                        <input type="tel" name="telefono" class="form-control">
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Correo electronico</label>
                                    <input type="email" name="correo" class="form-control" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Contrasena</label>
                                    <input type="password" name="contrasena" class="form-control" required>
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