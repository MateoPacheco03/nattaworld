<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
require_once 'config/database.php';

if (!isset($_SESSION['id']) || $_SESSION['rol'] != 'admin') {
    header('Location: login.php');
    exit();
}

$errores = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $nombre = htmlspecialchars($_POST['nombre']);
    $apellido1 = htmlspecialchars($_POST['apellido1']);
    $apellido2 = htmlspecialchars($_POST['apellido2']);
    $telefono = htmlspecialchars($_POST['telefono']);

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
        $errores = "Error al actualizar el usuario";
    }
} else {
    $id = $_GET['id'];
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
    <title>JuniorWorld — Editar usuario</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h2 class="mb-4">Editar usuario</h2>
            <?php if ($errores): ?>
                <div class="alert alert-danger"><?php echo $errores; ?></div>
            <?php endif; ?>
            <div class="card shadow-sm">
                <div class="card-body p-4">
                    <form method="POST">
                        <input type="hidden" name="id" value="<?php echo $usuario['id']; ?>">
                        <div class="mb-3">
                            <label class="form-label">Nombre</label>
                            <input type="text" name="nombre" class="form-control" value="<?php echo $usuario['nombre']; ?>" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Apellido 1</label>
                            <input type="text" name="apellido1" class="form-control" value="<?php echo $usuario['apellido1']; ?>" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Apellido 2</label>
                            <input type="text" name="apellido2" class="form-control" value="<?php echo $usuario['apellido2']; ?>">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Telefono</label>
                            <input type="tel" name="telefono" class="form-control" value="<?php echo $usuario['telefono']; ?>">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Correo</label>
                            <input type="email" class="form-control" value="<?php echo $usuario['correo']; ?>" disabled>
                        </div>
                        <button type="submit" class="btn btn-warning w-100">Guardar cambios</button>
                        <a href="listar_usuarios.php" class="btn btn-secondary w-100 mt-2">Cancelar</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>