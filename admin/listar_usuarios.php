<?php
session_start();
require_once '../config/database.php';

if (!isset($_SESSION['id']) || $_SESSION['rol'] != 'admin') {
    header('Location: ../login.php');
    exit();
}

// Recoger el termino de busqueda
$busqueda = isset($_GET['busqueda']) ? trim($_GET['busqueda']) : '';

if ($busqueda != '') {
    $stmt = $conexion->prepare("SELECT id, nombre, apellido1, apellido2, correo, telefono FROM USUARIO WHERE nombre LIKE :busqueda OR apellido1 LIKE :busqueda OR apellido2 LIKE :busqueda OR correo LIKE :busqueda ORDER BY nombre");
    $termino = '%' . $busqueda . '%';
    $stmt->bindParam(':busqueda', $termino);
} else {
    $stmt = $conexion->prepare("SELECT id, nombre, apellido1, apellido2, correo, telefono FROM USUARIO ORDER BY nombre");
}
$stmt->execute();
$usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nattworld — Usuarios</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/stylos.css">
    <link rel="stylesheet" href="../assets/css/botones.css">
</head>
<body>

    <?php include '../includes/navbar.php'; ?>

    <main>
        <div class="container mt-5">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="fw-bold">Lista de usuarios</h2>
                <a href="panel_admin.php" class="btn btn-outline-secondary">← Volver al panel</a>
            </div>

            <?php if (isset($_GET['mensaje']) && $_GET['mensaje'] == 'eliminado'): ?>
                <div class="alert alert-info">Usuario eliminado correctamente.</div>
            <?php endif; ?>
            <?php if (isset($_GET['mensaje']) && $_GET['mensaje'] == 'error'): ?>
                <div class="alert alert-danger">Hubo un error al eliminar el usuario.</div>
            <?php endif; ?>

            <!-- Buscador -->
            <form method="GET" class="mb-4">
                <div class="input-group">
                    <input type="text" name="busqueda" class="form-control" placeholder="Buscar por nombre, apellido o correo..." value="<?php echo htmlspecialchars($busqueda); ?>">
                    <button type="submit" class="btn btn-primary">Buscar</button>
                    <?php if ($busqueda != ''): ?>
                        <a href="listar_usuarios.php" class="btn btn-outline-secondary">Limpiar</a>
                    <?php endif; ?>
                </div>
            </form>

            <?php if ($busqueda != ''): ?>
                <p class="text-muted">Resultados para: <strong><?php echo htmlspecialchars($busqueda); ?></strong> (<?php echo count($usuarios); ?> encontrados)</p>
            <?php endif; ?>

            <?php if (count($usuarios) == 0): ?>
                <div class="alert alert-info">No se encontraron usuarios.</div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-striped table-bordered align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th>ID</th>
                                <th>Nombre</th>
                                <th>Apellido 1</th>
                                <th>Apellido 2</th>
                                <th>Correo</th>
                                <th>Telefono</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($usuarios as $u): ?>
                                <tr>
                                    <td><?php echo $u['id']; ?></td>
                                    <td><?php echo htmlspecialchars($u['nombre']); ?></td>
                                    <td><?php echo htmlspecialchars($u['apellido1']); ?></td>
                                    <td><?php echo htmlspecialchars($u['apellido2']); ?></td>
                                    <td><?php echo htmlspecialchars($u['correo']); ?></td>
                                    <td><?php echo htmlspecialchars($u['telefono']); ?></td>
                                    <td>
                                        <a href="editar_usuario.php?id=<?php echo $u['id']; ?>" class="btn btn-outline-primary btn-sm">Editar</a>
                                        <a href="eliminar_usuario.php?id=<?php echo $u['id']; ?>" class="btn btn-outline-danger btn-sm" onclick="return confirm('Seguro que quieres eliminar este usuario?')">Eliminar</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </main>

    <?php include '../includes/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>